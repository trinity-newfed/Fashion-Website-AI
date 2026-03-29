import os
import torch
import cv2
import numpy as np
from PIL import Image
from flask import Flask, request, jsonify
from flask_cors import CORS
from transformers import SegformerImageProcessor, SegformerForSemanticSegmentation
from diffusers import ControlNetModel, StableDiffusionControlNetInpaintPipeline
import mysql.connector
from threading import Lock

app = Flask(__name__)
CORS(app)

progress_dict = {}
progress_lock = Lock()

device = "cuda" if torch.cuda.is_available() else "cpu"
dtype = torch.float16 if device == "cuda" else torch.float32

seg_model_name = "sayeed99/segformer_b3_clothes"

seg_processor = SegformerImageProcessor.from_pretrained(seg_model_name)
seg_model = SegformerForSemanticSegmentation.from_pretrained(seg_model_name)
seg_model.to(device)
seg_model.eval()

controlnet = ControlNetModel.from_pretrained(
    "lllyasviel/control_v11p_sd15_canny",
    torch_dtype=dtype
)

pipe = StableDiffusionControlNetInpaintPipeline.from_pretrained(
    "runwayml/stable-diffusion-v1-5",
    controlnet=controlnet,
    torch_dtype=dtype
)

if device == "cuda":
    pipe.to(device)
    pipe.enable_xformers_memory_efficient_attention()
    pipe.enable_model_cpu_offload()
else:
    pipe.enable_vae_slicing()

pipe.safety_checker = None

pipe.load_ip_adapter(
    "h94/IP-Adapter",
    subfolder="models",
    weight_name="ip-adapter-plus_sd15.bin"
)

pipe.set_ip_adapter_scale(0.9)

def resize_with_padding(img, target_size=(512,512)):
    w, h = img.size
    scale = min(target_size[0]/w, target_size[1]/h)
    new_w, new_h = int(w*scale), int(h*scale)
    img_resized = img.resize((new_w, new_h), Image.LANCZOS)
    new_img = Image.new("RGB", target_size, (0,0,0))
    paste_x = (target_size[0]-new_w)//2
    paste_y = (target_size[1]-new_h)//2
    new_img.paste(img_resized, (paste_x, paste_y))
    return new_img

def generate_mask(image: Image.Image):
    orig_w, orig_h = image.size
    inputs = seg_processor(images=image, return_tensors="pt")
    inputs = {k: v.to(device) for k, v in inputs.items()}
    with torch.no_grad():
        outputs = seg_model(**inputs)
    logits = outputs.logits
    upsampled_logits = torch.nn.functional.interpolate(
        logits,
        size=(orig_h, orig_w),
        mode="bilinear",
        align_corners=False,
    )
    pred = upsampled_logits.argmax(dim=1)[0].cpu().numpy()
    mask = np.zeros_like(pred, dtype=np.uint8)
    mask[pred == 4] = 255
    kernel = np.ones((8,8),np.uint8)
    mask = cv2.dilate(mask,kernel,iterations=1)
    return Image.fromarray(mask)

def preprocess_person_cloth(person_img: Image.Image, cloth_img: Image.Image):
    person_resized = resize_with_padding(person_img)
    cloth_resized = resize_with_padding(cloth_img)

    person_np = np.array(person_resized)
    cloth_np = np.array(cloth_resized)

    gray = cv2.cvtColor(person_np, cv2.COLOR_RGB2GRAY)
    face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + "haarcascade_frontalface_default.xml")
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5)
    face_mask = np.zeros((512,512), dtype=np.uint8)
    for (x,y,w,h) in faces:
        face_mask[y:y+h, x:x+w] = 255

    seg_mask = generate_mask(person_resized)
    mask_np = np.array(seg_mask)
    mask_np[face_mask==255] = 0

    person_np[mask_np>200] = cloth_np[mask_np>200]

    for (x,y,w,h) in faces:
        person_np[y:y+h, x:x+w] = np.array(person_resized)[y:y+h, x:x+w]

    result_img = Image.fromarray(person_np)
    return result_img, mask_np

@app.route("/api/generate", methods=["POST"])
def api_generate():
    if "person" not in request.files or "cloth" not in request.form:
        return jsonify({"error": "Missing data"}), 400

    person_file = request.files["person"]
    cloth_path = request.form["cloth"]
    userID = request.form.get("user_id")

    with progress_lock:
        progress_dict[userID] = 0

    person_img = Image.open(person_file).convert("RGB")
    cloth_img = Image.open(cloth_path).convert("RGB")

    person_blended, mask_np = preprocess_person_cloth(person_img, cloth_img)
    mask = Image.fromarray(mask_np)
    
    person_np = np.array(person_blended)
    edges = cv2.Canny(person_np, 50, 150)
    edges = np.stack([edges]*3, axis=-1)
    canny_image = Image.fromarray(edges)

    seed = torch.randint(0,1_000_000,(1,)).item()
    generator = torch.Generator(device).manual_seed(seed)

    def progress_callback(step, timestep, latents):
        percent = int(((step+1)/40)*100)
        with progress_lock:
            progress_dict[userID] = percent
            current = progress_dict.get(userID, 0)
            if percent > current:
                progress_dict[userID] = percent

    result = pipe(
        prompt="""
        A realistic photo of the same person wearing the clothing from the reference image,
        natural lighting,
        realistic fabric texture,
        preserve original cloth color,
        slightly soft shadows on white fabric,
        realistic wrinkles and folds""",
        negative_prompt="""
        color change, faded colors,
        blurry, distorted body, extra arms""",
        image=person_blended,
        mask_image=mask,
        control_image=canny_image,
        ip_adapter_image=cloth_img,
        num_inference_steps=40,
        strength=0.65,
        generator=generator,
        guidance_scale=8,
        callback=progress_callback,
        callback_steps=1
    )

    output_dir = os.path.join("static","outputs",f"user_{userID}")
    os.makedirs(output_dir, exist_ok=True)
    filename = f"output_{seed}.png"
    output_path = os.path.join(output_dir, filename)
    result.images[0].save(output_path)

    with progress_lock:
        progress_dict[userID] = 100

    sql = "INSERT INTO tryon (user_id, cloth_path, result_img) VALUES (%s,%s,%s)"
    try:
        db = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="TF_Database"
        )
        cursor = db.cursor()
        cursor.execute(sql,(userID, cloth_path, filename))
        db.commit()
    except Exception as e:
        print("DB ERROR:", e)
        return jsonify({"error":"Database failed"}),500
    finally:
        cursor.close()
        db.close()

    return jsonify({
        "status":"success",
        "image":f"outputs/user_{userID}/{filename}",
        "seed": seed,
        "redirect": "/Trinity-Style-AI/Pages/user.php"
    })

@app.route("/api/progress/<userID>")
def get_progress(userID):
    with progress_lock:
        progress = progress_dict.get(userID,0)
    if progress>=100:
        with progress_lock:
            progress_dict[userID]=0
        return jsonify({
            "status":"done",
            "progress":100,
            "redirect":"/Trinity-Style-AI/Pages/user.php"
        })
    else:
        return jsonify({
            "status":"processing",
            "progress":progress
        })

if __name__ == "__main__":
    app.run(debug=False, threaded=True)

import os
import torch
import cv2
import numpy as np
from PIL import Image
from flask import Flask, request, jsonify, redirect
from flask_cors import CORS
from transformers import SegformerImageProcessor, SegformerForSemanticSegmentation
from diffusers import ControlNetModel, StableDiffusionControlNetInpaintPipeline
import mysql.connector

db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="TF_Database"
)

cursor = db.cursor()

app = Flask(__name__)
CORS(app)

progress_dict = {}

device = "cuda" if torch.cuda.is_available() else "cpu"
dtype = torch.float16 if device == "cuda" else torch.float32

print(f"Using device: {device}")

#SEGMENTATION
seg_model_name = "sayeed99/segformer_b3_clothes"

seg_processor = SegformerImageProcessor.from_pretrained(seg_model_name)
seg_model = SegformerForSemanticSegmentation.from_pretrained(seg_model_name)
seg_model.to(device)
seg_model.eval()

print("Segmentation model loaded")

#CONTROLNET
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

#IP ADAPTER
pipe.load_ip_adapter(
    "h94/IP-Adapter",
    subfolder="models",
    weight_name="ip-adapter-plus_sd15.bin"
)

pipe.set_ip_adapter_scale(1.0)

print("Diffusion pipeline loaded")

#AUTO MASK 
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

def resize_keep_ratio(img, size=768):
    w, h = img.size
    scale = size / max(w, h)
    new_w = int(w * scale)
    new_h = int(h * scale)

    img = img.resize((new_w, new_h), Image.LANCZOS)

    canvas = Image.new("RGB", (size, size), (0,0,0))
    canvas.paste(img, ((size-new_w)//2, (size-new_h)//2))

    return canvas

#API FLASK
@app.route("/api/generate", methods=["POST"])
def api_generate():

    print("FORM DATA:", request.form)

    if "person" not in request.files or "cloth" not in request.form:
        return jsonify({"error": "Missing data"}), 400

    person_file = request.files["person"]
    cloth_path = request.form["cloth"]
    username = request.form.get("username")

    progress_dict[username] = 0

    person = Image.open(person_file).convert("RGB").resize((768,1024), Image.LANCZOS)
    cloth = Image.open(cloth_path).convert("RGB").resize((768,1024), Image.LANCZOS)

    mask = generate_mask(person)
    mask = mask.resize((768,1024), Image.NEAREST)

    person_np = np.array(person)
    cloth_np = np.array(cloth)
    mask_np = np.array(mask)

    cloth_np = cv2.resize(cloth_np, (person_np.shape[1], person_np.shape[0]))
    person_np[mask_np > 200] = cloth_np[mask_np > 200]

    person = Image.fromarray(person_np)

    person_bg = person_np.copy()
    person_bg[mask_np > 128] = 0

    edges = cv2.Canny(person_np, 50, 150)
    edges = np.stack([edges] * 3, axis=-1)
    canny_image = Image.fromarray(edges)

    seed = torch.randint(0, 1_000_000, (1,)).item()
    generator = torch.Generator(device).manual_seed(seed)

    def progress_callback(step, timestep, latents):
        percent = int(((step+1) / 40) * 100)
        progress_dict[username] = percent


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
        blurry, distorted body, extra arms
        """,
        image=person,
        mask_image=mask,
        control_image=canny_image,
        ip_adapter_image=cloth,
        num_inference_steps=40,
        strength=0.65,
        generator=generator,
        guidance_scale=8,
        callback=progress_callback,
        callback_steps=1
    )

    output_dir = os.path.join("static", "outputs", f"user_{username}")
    os.makedirs(output_dir, exist_ok=True)

    filename = f"output_{seed}.png"
    output_path = os.path.join(output_dir, filename)

    result.images[0].save(output_path)

    progress_dict[username] = 100

    print("INSERT USER:", username)
    print("INSERT CLOTH:", cloth_path)

    sql = """
    INSERT INTO tryon (username, cloth_path, result_img)
    VALUES (%s, %s, %s)
    """

    print("USERNAME BEFORE INSERT:", username)

    cursor.execute(sql, (
    username,
    cloth_path,
    filename
    ))

    db.commit()

    return jsonify({
    "status": "success",
    "image": f"outputs/user_{username}/{filename}",
    "seed": seed,
    "redirect": "/Trinity-Style-AI/Pages/user.php"
})


#API HOOK FRONTEND
@app.route("/api/progress/<username>")
def get_progress(username):

    progress = progress_dict.get(username, 0)

    print("PROGRESS:", username, progress)

    return jsonify({
        "progress": progress
    })

if __name__ == "__main__":
    app.run(debug=False, threaded=True)
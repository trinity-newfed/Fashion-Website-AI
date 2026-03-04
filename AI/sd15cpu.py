import os
import torch
import cv2
import numpy as np
from PIL import Image
from flask import Flask, request, jsonify
from transformers import SegformerImageProcessor, SegformerForSemanticSegmentation
from diffusers import ControlNetModel, StableDiffusionControlNetInpaintPipeline

app = Flask(__name__)

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

    mask = cv2.GaussianBlur(mask, (3, 3), 0)

    return Image.fromarray(mask)

#API FLASK

@app.route("/api/generate", methods=["POST"])
def api_generate():

    if "person" not in request.files or "cloth" not in request.form:
        return jsonify({"error": "Missing data"}), 400

    person_file = request.files["person"]
    cloth_path = request.form["cloth"]

    person = Image.open(person_file).convert("RGB").resize((512, 512))
    cloth = Image.open(cloth_path).convert("RGB").resize((512, 512))

    mask = generate_mask(person).resize((512, 512))

    person_np = np.array(person)
    mask_np = np.array(mask)

    person_bg = person_np.copy()
    person_bg[mask_np > 128] = 0

    edges = cv2.Canny(person_bg, 50, 150)
    edges = np.stack([edges] * 3, axis=-1)
    canny_image = Image.fromarray(edges)

    seed = torch.randint(0, 1_000_000, (1,)).item()
    generator = torch.Generator(device).manual_seed(seed)

    result = pipe(
        prompt="A photo of the same person wearing the exact clothing from the reference image, natural lighting, detailed fabric, high quality",
        negative_prompt="blurry, distorted body, extra arms, bad anatomy, low quality, redesign, change face",
        image=person,
        mask_image=mask,
        control_image=canny_image,
        ip_adapter_image=cloth,
        num_inference_steps=50,
        strength=0.98,
        generator=generator,
        guidance_scale=9
    )

    output_dir = os.path.join("static", "outputs")
    os.makedirs(output_dir, exist_ok=True)

    filename = f"output_{seed}.png"
    output_path = os.path.join(output_dir, filename)

    result.images[0].save(output_path)

    return jsonify({
    "status": "success",
    "image": f"outputs/{filename}",
    "seed": seed
})

if __name__ == "__main__":
    app.run(debug=False)

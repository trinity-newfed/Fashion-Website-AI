import torch
from flask import Flask, request, send_file
from diffusers import StableDiffusionPipeline
from PIL import Image
import io

app = Flask(__name__)
app.config["MAX_CONTENT_LENGTH"] = 16 * 1024 * 1024

print("LOADING MODEL...")

model_id = "runwayml/stable-diffusion-v1-5"
device = "cuda" if torch.cuda.is_available() else "cpu"

pipe = StableDiffusionPipeline.from_pretrained(
    model_id,
    torch_dtype=torch.float16 if device == "cuda" else torch.float32
).to(device)

pipe.load_ip_adapter(
    "h94/IP-Adapter",
    subfolder="models",
    weight_name="ip-adapter_sd15.bin"
)

pipe.set_ip_adapter_scale(0.8)

print("✅ MODEL LOADED")


@app.route("/")
def home():
    return "Server running"


@app.route("/generate", methods=["POST"])
def generate():
    try:
        person_file = request.files.get("person")
        cloth_file = request.files.get("cloth")

        if not person_file or not cloth_file:
            return "Missing image", 400

        person_img = Image.open(person_file).convert("RGB").resize((512, 512))
        cloth_img = Image.open(cloth_file).convert("RGB").resize((512, 512))

        prompt = "a realistic studio photo of a man wearing this cloth, detailed fabric, natural lighting, high quality"

        result = pipe(
            prompt=prompt,
            image=person_img,
            ip_adapter_image=cloth_img,
            num_inference_steps=25
        ).images[0]

        img_io = io.BytesIO()
        result.save(img_io, format="PNG")
        img_io.seek(0)

        return send_file(img_io, mimetype="image/png")

    except Exception as e:
        print("ERROR:", e)
        return str(e), 500


if __name__ == "__main__":
    app.run(port=5000, debug=False)
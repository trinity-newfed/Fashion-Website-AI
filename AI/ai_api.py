import torch
from flask import Flask, request, send_file
from diffusers import StableDiffusionPipeline
from PIL import Image
import io

app = Flask(__name__)

print("THIS IS THE CORRECT FILE")

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

pipe.set_ip_adapter_scale(0.4)

if __name__ == "__main__":
    app.run(port=5000, debug=True)

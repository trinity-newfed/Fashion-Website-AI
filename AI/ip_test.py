import torch
from diffusers import StableDiffusionImg2ImgPipeline
from PIL import Image

device = "cuda" if torch.cuda.is_available() else "cpu"

pipe = StableDiffusionImg2ImgPipeline.from_pretrained(
    "runwayml/stable-diffusion-v1-5",
    torch_dtype=torch.float16 if device == "cuda" else torch.float32
).to(device)

pipe.load_ip_adapter(
    "h94/IP-Adapter",
    subfolder="models",
    weight_name="ip-adapter_sd15.bin"
)

person_img = Image.open("person.jpg").convert("RGB").resize((512, 512))
cloth_img = Image.open("cloth.png").convert("RGB").resize((512, 512))

prompt = "a realistic photo of a person wearing this coat"

result = pipe(
    prompt=prompt,
    image=person_img,
    ip_adapter_image=cloth_img,
    strength=0.8,
    num_inference_steps=30
).images[0]

result.save("output.png")

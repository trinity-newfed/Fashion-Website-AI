from diffusers import StableDiffusionPipeline
import torch

model_id = "runwayml/stable-diffusion-v1-5"

pipe = StableDiffusionPipeline.from_pretrained(
    model_id,
    torch_dtype=torch.float32
)

pipe = pipe.to("cpu")

prompt = "a beautiful vietnamese fashion model, studio lighting, 4k photo"

image = pipe(prompt, num_inference_steps=25).images[0]

image.save("output.png")

print("Done! Image saved as output.png")

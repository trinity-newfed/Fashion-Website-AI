import torch
from diffusers import StableDiffusionImg2ImgPipeline
from PIL import Image
import gradio as gr

model_id = "CompVis/stable-diffusion-v1-4"

pipe = StableDiffusionImg2ImgPipeline.from_pretrained(
    model_id,
    torch_dtype=torch.float32
).to("cpu")

def generate(prompt, image, strength):
    image = image.convert("RGB").resize((512, 512))
    
    result = pipe(
        prompt=prompt,
        image=image,
        strength=strength,
        num_inference_steps=25
    ).images[0]
    
    return result

interface = gr.Interface(
    fn=generate,
    inputs=[
        gr.Textbox(label="Prompt"),
        gr.Image(type="pil", label="Upload Image"),
        gr.Slider(0.1, 1.0, value=0.7, label="Strength")
    ],
    outputs=gr.Image(label="Output"),
    title="Stable Diffusion 1.4 - Img2Img"
)

interface.launch()

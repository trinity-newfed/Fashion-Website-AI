import torch
from diffusers import StableDiffusionPipeline
from PIL import Image
import gradio as gr

model_id = "runwayml/stable-diffusion-inpainting"

pipe = StableDiffusionInpaintPipeline.from_pretrained(
    model_id,
    torch_dtype=torch.float32
).to("cpu")

def try_on(prompt, image, mask):
    image = image.resize((512, 512))
    mask = mask.resize((512, 512))

    result = pipe(
        prompt=prompt,
        image=image,
        mask_image=mask,
        num_inference_steps=25
    ).images[0]

    return result

interface = gr.Interface(
    fn=try_on,
    inputs=[
        gr.Textbox(label="Describe the clothes"),
        gr.Image(type="pil", label="Person Image"),
        gr.Image(type="pil", label="Mask (white = replace)")
    ],
    outputs=gr.Image(),
    title="Fake Virtual Try-On (CPU Demo)"
)

interface.launch()

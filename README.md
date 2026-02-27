# FOR REQUIREMENT PLEASE READ requirement.txt

#REQUIRE#
first time download (>5.4G)
python ver 3.10.x

#INSTALL VIRTUAL ENVIRONMENT#
cd AI
python -m venv sd14
sd14\Scripts\activate

#IF BLOCK#
Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
sd14\Scripts\Activate.ps1

#OS INSTALL#
pip install --upgrade pip
pip install torch torchvision --index-url https://download.pytorch.org/whl/cpu
pip install diffusers transformers accelerate safetensors pillow gradio

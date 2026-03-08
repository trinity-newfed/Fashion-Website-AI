#PINELINE#
SAM (SEGMENTATION)
MASK
CONTROLNET
IP ADAPTER
STABLE DIFFUSION 1.5 INPAINTING

#REQUIRE#
first time download (>5.4G)
python ver 3.10.x

#INSTALL VIRTUAL ENVIRONMENT#
cd AI
python -m venv sd15
sd15\Scripts\activate

#IF BLOCK#
Set-ExecutionPolicy -Scope Process -ExecutionPolicy Bypass
sd15\Scripts\Activate.ps1

#OS INSTALL#
pip install -r requirements.txt (can't install torch + cpu)
pip install torch==2.6.0 --index-url https://download.pytorch.org/whl/cpu (install this instead)

#DATABASE
pip install mysql-connector-python flask-cors

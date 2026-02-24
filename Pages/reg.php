<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: #111;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: white;
}

.reg-box {
    background: #1c1c1c;
    width: 350px;
    padding: 40px 35px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 0 18px rgba(0,0,0,0.7);
}

.reg-box .avatar {
    width: 70px;
    height: 70px;
    background: gray;
    border-radius: 50%;
    margin: -45px auto 10px auto;
    display: flex;
    align-items: center;
}

.reg-box h2 {
    margin-bottom: 5px;
}

.error {
    color: #ff6b6b;
    font-size: 14px;
    margin-bottom: 15px;
    display: none;
}

.input-group {
    text-align: left;
    margin-bottom: 18px;
}

.input-group label {
    font-size: 14px;
    opacity: 0.8;
}

.input-group input {
    width: 100%;
    padding: 10px 12px;
    margin-top: 5px;
    border-radius: 6px;
    border: none;
    outline: none;
    background: #2d2d2d;
    color: white;
}

.gender-group {
    text-align: left;
    margin-bottom: 18px;
}

.gender-group label {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 5px;
    font-size: 14px;
    opacity: 0.9;
}

.password-wrapper {
    position: relative;
}

.show-btn {
    position: absolute;
    right: 12px;
    top: 70%;
    transform: translateY(-50%);
    font-size: 13px;
    color: #ccc;
    cursor: pointer;
    user-select: none;
}

button {
    width: 50%;
    padding: 10px;
    border: none;
    background: #1f6feb;
    border-radius: 6px;
    color: white;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    transition: .3s;
}

button:hover {
    background: #3b82f6;
}

.login-link {
    margin-top: 20px;
    font-size: 14px;
    opacity: 0.7;
}

.login-link a {
    color: #1f6feb;
    text-decoration: none;
}


.pop-up{
    position: fixed;
    z-index: 2;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    left: 50%;
    transform: translateX(-50%);
    visibility: hidden;
    opacity: 0;
    transition: .3s all;
}
.pop-up.show{
    visibility: visible;
    opacity: 1;
    transition: .3s all;
}
.avatar-form{
    width: 50%;
    height: 90%;
    background-color: rgba(255, 255, 255, 0.9);
    display: grid;
    grid-gap: 10px;
}
.btn-ava{
    position: absolute;
    display: flex;
    align-self: flex-end;
    justify-content: center;
    align-items: center;
    width: 50%;
    height: 5%;
    background-color: transparent;
}
.btn-ava.show{
    background-color: rgba(0, 0, 0, 0.75);
}
.btn-input{
    max-width: 20%;
    color: black;
    border: none;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: clamp(1rem, 1.25vw, 2.5rem);
    background-color: transparent;
}
.btn-input:hover{
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
}
.btn-input.show{
    color: white;
    background-color: transparent;
}
#preview{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
</head>
<body>
<form action="register.php" method="POST">
<div class="reg-box">
    <?php if(isset($_SESSION['avatar_temp'])): ?>
        <img class="avatar" id="avatar" src="../upload/<?=$_SESSION['avatar_temp']?>" alt="">
    <?php else: ?>
        <div class="avatar" id="avatar">Choose an avatar</div>
    <?php endif; ?>
    <h2>REGISTER</h2>
    <p class="error" id="errorText">Please fill all fields before submitting</p>

    <div class="input-group">
        <label>Username</label>
        <input type="text" id="username" name="username">
    </div>

    <div class="input-group">
        <label>Hotline</label>
        <input type="text" id="phone" name="user_hotline">
    </div>

    <div class="input-group">
        <label>Email</label>
        <input type="email" id="email" name="email">
    </div>
    <div class="input-group">
        <label>Address</label>
        <input type="text" id="address" name="user_address">
    </div>

    <div class="gender-group">
        <label>Giới tính:</label>
        <label><input type="radio" name="gender" value="Nam"> Male</label>
        <label><input type="radio" name="gender" value="Nữ"> Female</label>
        <label><input type="radio" name="gender" value="Bia đia"> Other</label>
    </div>

    <div class="input-group password-wrapper">
        <label>Password</label>
        <input type="password" id="password" name="user_password">
        <span class="show-btn" onclick="togglePassword()">Show</span>
    </div>
    
    <button id="btn-signup">Sign Up</button>

    <div class="login-link">
        Already have an account? <a href="log.php">Login</a>
    </div>
</div>
</form>

<div class="pop-up" id="pop-up">
    <div class="avatar-form" id="avatar-form">
        <?php if(isset($_SESSION['avatar_temp'])): ?>
            <img id="preview" src="../upload/<?=$_SESSION['avatar_temp']?>">
        <?php else: ?>
            <img id="preview" style="display: none;">
        <?php endif; ?>
        <div class="btn-ava" id="btn-ava">
            <form action="../Database/upload.php" method="post" enctype="multipart/form-data" style="width: 100%;, height: 100%; display: flex; justify-content: space-around;">
                <input type="file" id="imageInput" name="img" accept="image/*" hidden>
                    <label for="imageInput" class="btn-input">Choose file</label>
                <input type="submit" name="submit" value="upload" class="btn-input" style="width: 100%; height: 100%;">
            </form>
        </div>
    </div>
</div>

<script>
history.scrollRestoration = "manual";

function togglePassword() {
    let pass = document.getElementById("password");
    let btn = document.querySelector(".show-btn");

    if (pass.type === "password") {
        pass.type = "text";
        btn.textContent = "Hide";
    } else {
        pass.type = "password";
        btn.textContent = "Show";
    }
}
const username = document.getElementById('username');
const pass = document.getElementById('password');
const container = document.getElementById('btn-signup');

const avatar = document.getElementById("avatar");
const pop = document.getElementById("pop-up");
const avatar_form = document.getElementById("avatar-form");
const btn_ava = document.getElementById("btn-ava");
const input = document.querySelectorAll(".btn-input");

avatar.addEventListener('click', ()=>{
    pop.classList.add("show");
});
pop.addEventListener('click', (e)=>{
    if(!avatar_form.contains(e.target)){
        pop.classList.remove("show");
        btn_ava.classList.remove("show");
        inuput.classList.remove("show");
    }
});

document.getElementById("imageInput").addEventListener("change", function(event) {
    btn_ava.classList.add("show");
    input.forEach(i => i.classList.add("show"));
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(e) {
        const img = document.getElementById("preview");
        img.src = e.target.result;
        img.style.display = "block";
    };

    reader.readAsDataURL(file);
});
</script>
</body>
</html>

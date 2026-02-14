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
    margin: -75px auto 10px auto;
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
</style>
</head>
<body>
<form action="register.php" method="POST">
<div class="reg-box">
    <input type="file" class="avatar" name="img">
    <h2>REGISTER</h2>
    <p class="error" id="errorText">Please fill all fields before submitting</p>

    <div class="input-group">
        <label>Username</label>
        <input type="text" id="username" name="username">
    </div>

    <div class="input-group">
        <label>Số điện thoại</label>
        <input type="text" id="phone" name="user_hotline">
    </div>

    <div class="input-group">
        <label>Email</label>
        <input type="email" id="email" name="email">
    </div>
    <div class="input-group">
        <label>Địa chỉ</label>
        <input type="text" id="address" name="user_address">
    </div>

    <div class="gender-group">
        <label>Giới tính:</label>
        <label><input type="radio" name="gender" value="Nam"> Nam</label>
        <label><input type="radio" name="gender" value="Nữ"> Nữ</label>
        <label><input type="radio" name="gender" value="Bia đia"> Khác</label>
    </div>

    <div class="input-group password-wrapper">
        <label>Password</label>
        <input type="password" id="password" name="user_password">
        <span class="show-btn" onclick="togglePassword()">Hiện</span>
    </div>
    
    <button id="btn-signup">Sign Up</button>

    <div class="login-link">
        Already have an account? <a href="log.php">Login</a>
    </div>
</div>
</form>


<script>
function togglePassword() {
    let pass = document.getElementById("password");
    let btn = document.querySelector(".show-btn");

    if (pass.type === "password") {
        pass.type = "text";
        btn.textContent = "Ẩn";
    } else {
        pass.type = "password";
        btn.textContent = "Hiện";
    }
}
const username = document.getElementById('username');
const pass = document.getElementById('password');
const container = document.getElementById('btn-signup');
</script>
</body>
</html>

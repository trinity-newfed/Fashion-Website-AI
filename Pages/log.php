
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "TF_Database");
if ($conn->connect_error) {
    die("error" . $conn->connect_error);
}

$user = $conn
  ->query("SELECT * FROM userdata")
  ->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body {
    margin: 0;
    padding: 0;
    background: #1f242d;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: white;
}

.login-box {
    background: #141c2c;
    padding: 45px 40px;
    border-radius: 14px;
    width: 360px;
    text-align: center;
    position: relative;
    box-shadow: 0 0 18px rgba(0,0,0,0.7);
}

.avatar {
    width: 75px;
    height: 75px;
    background: #3a3a3a;
    border-radius: 50%;
    position: absolute;
    top: -35px;
    left: 50%;
    transform: translateX(-50%);
}

h2 {
    margin-top: 25px;
}

.error {
    color: #ff5f5f;
    font-size: 14px;
    margin-bottom: 12px;
    display: none;
}

.input-group {
    text-align: left;
    margin-top: 15px;
}

.input-group label {
    font-size: 14px;
    opacity: 0.8;
}

.input-group input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 6px;
    border: none;
    outline: none;
    margin-top: 5px;
    background: #333;
    color: white;
}

.options {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin: 12px 0 22px;
    opacity: 0.9;
}

.btn-container {
    position: relative;
    width: 100%;
    height: 50px;
    overflow: visible;
}

#login-btn {
    position: absolute;
    left: 50%;
    top: 0;
    transform: translateX(-50%);
    width: 100px;
    padding: 10px 0;
    border: none;
    border-radius: 6px;
    background: #1f6feb;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.35s ease;
}

.signup {
    margin-top: 25px;
    font-size: 14px;
    opacity: 0.7;
}

.signup a {
    color: #1f6feb;
    text-decoration: none;
}
.show-btn {
    position: absolute;
    right: 25px;
    top: 53%;
    transform: translateY(-50%);
    font-size: 13px;
    color: #ccc;
    cursor: pointer;
    user-select: none;
}
</style>
</head>
<body>
<form action="login.php" method="POST">
<div class="login-box">
    <h2>LOGIN</h2>
    <p class="error" id="errorText">Please fill the input fields before proceeding</p>

    <div class="input-group">
        <label>Username</label>
        <input type="text" id="username" name="username">
    </div>

    <div class="input-group">
        <label>Password</label>
        <input type="password" id="password" name="user_password">
        <span class="show-btn" onclick="togglePassword()">Hiện</span>
    </div>

    <div class="options">
        <label><input type="checkbox"> Remember me</label>
        <a href="#" style="color:#ccc;">Forget Password?</a>
    </div>

    <div class="btn-container">
        <button id="login-btn">Login</button>
    </div>

    <div class="signup">
        Don't have an Account? <a href="reg.php">Sign up</a>
    </div>
</div>
</form>
<script>
const uname = document.querySelector('#username');
const pass = document.querySelector('#password');
const btn = document.querySelector('#login-btn');
const errorText = document.querySelector('#errorText');

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
</script>

</body>
</html>

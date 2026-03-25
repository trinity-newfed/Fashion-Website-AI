<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trinity Style - Auth</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
    <style>
      body,
      html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        font-family: "Montserrat", sans-serif;
        overflow: hidden;
        user-select: none;
      }

      .banner {
        position: relative;
        width: 100vw;
        height: 100vh;
        max-width: 1500px;
        max-height: 900px;
        margin: auto;
        background: url("../Pictures/Banners/banner_yellow.png") no-repeat
          center;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .info-box {
        position: relative;
        width: 250px;
        height: 100vh;
        max-height: 900px;
        padding: 0 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        z-index: 10;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
      }

      .login-box {
        background: rgba(0, 0, 0, 0.05);
        border-left: 1px solid rgba(255, 255, 255, 0.2);
      }

      .brand-header {
        margin-bottom: 40px;
      }
      .brand-header h2 {
        font-weight: 600;
        font-size: 28px;
        margin: 0;
        letter-spacing: 2px;
        text-transform: uppercase;
      }
      .brand-header p {
        font-size: 13px;
        color: #333;
        margin-top: 5px;
      }

      .input-group {
        position: relative;
        margin-bottom: 30px;
        width: 100%;
      }
      .input-group input {
        font-size: 15px;
        padding: 10px 0;
        display: block;
        width: 100%;
        border: none;
        border-bottom: 1.5px solid #000;
        background: transparent;
        outline: none;
      }
      .input-group label {
        color: #000;
        font-size: 14px;
        position: absolute;
        pointer-events: none;
        left: 0;
        top: 10px;
        transition: 0.3s ease all;
      }
      .input-group input:focus ~ label,
      .input-group input:valid ~ label {
        top: -18px;
        font-size: 12px;
        font-weight: 600;
      }

      .input-group input:-webkit-autofill ~ label,
      .input-group input:focus ~ label{
        top: -18px;
        font-size: 12px;
        font-weight: 600;
        color: #000;
      }

      input:-webkit-autofill,
      input:-webkit-autofill:hover, 
      input:-webkit-autofill:focus, 
      input:-webkit-autofill:active{
        -webkit-box-shadow: 0 0 0 30px transparent !important;
        -webkit-text-fill-color: #000 !important;
        transition: background-color 5000s ease-in-out 0s;
      }

      .input-group input::placeholder {
        color: transparent;
      }

      .gender-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        display: block;
      }
      .gender-container {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
      }
      .gender-box {
        position: relative;
        flex: 1;
        height: 40px;
        perspective: 1000px;
        cursor: pointer;
      }
      .male-front,
      .male-back {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 4px;
        backface-visibility: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 12px;
        transition: 0.6s;
        border: 1px solid rgba(0, 0, 0, 0.1);
      }
      .male-front {
        background: #fff;
        color: #000;
      }
      .male-back {
        transform: rotateY(180deg);
        color: #fff;
        font-weight: bold;
      }
      .gender-box:hover .male-front {
        transform: rotateY(180deg);
      }
      .gender-box:hover .male-back {
        transform: rotateY(360deg);
      }
      .gender-box.stay .male-front{
        transform: rotateY(180deg);
      }
      .gender-box.stay .male-back{
        transform: rotateY(360deg);
      }
      .btn-action {
        background: #000;
        color: #fff;
        border: 1px solid #000;
        padding: 15px;
        width: 100%;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
      }
      .btn-action:hover {
        background: #b8860b;
        border-color: #b8860b;
      }

      .extra-link {
        margin-top: 20px;
        text-align: center;
        font-size: 12px;
      }
      .extra-link a {
        color: #000;
        font-weight: 600;
        text-decoration: none;
      }

      @media (max-width: 850px) {
        .banner {
          flex-direction: column;
          overflow-y: auto;
          justify-content: flex-start;
        }
        .info-box {
          width: 100%;
          padding: 50px 20px;
        }
      }
      .login-link {
        margin-top: 25px;
        text-align: center;
        font-size: 13px;
      }

      .login-link a {
        color: #000;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid #000;
      }
      #regForm, #loginForm{
        position: absolute;
        right: 0;
        transition: .5s all;
      }
      #regForm{
        opacity: 0;
        visibility: hidden;
        transform: translateX(100%);
      }
      #regForm.move{
        opacity: 1;
        visibility: visible;
        transition: .5s all;
        transform: translateX(0);
      }
      #loginForm.move{
        opacity: 0;
        visibility: hidden;
        transform: translateX(100%);
        transition: .5s all;
      }
      #leftContainer{
        width: 10%;
        height: 100%;
        max-height: 900px;
        left: 5%;
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: center;
        color: white;
        gap: 15px;
        cursor: default;
      }
      #leftContainer span{
        width: 100%;
        height: 20px;
        font-size: clamp(1rem, 1vw, 1.5rem);
        color: rgba(255, 255, 255, 0.481);
        cursor: default;
        transition: .5s all;
      }
      #leftContainer span:hover{
        color: white;
        cursor: pointer;
        position: relative;
        transition: .5s all;
        padding-left: 30px;
      }
      #leftContainer span::before{
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        width: 0;
        height: 2px;
        background: white;
        transform: translateY(-50%);
        transition: .001ms all;
        opacity: 0;
      }
      #leftContainer span:hover::before{
        opacity: 1;
        transition: .6s all;
        width: 15%;
      }
      input[type="number"]::-webkit-outer-spin-button,
      input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      @media(max-width: 600px){
        #leftContainer{
          width: 80%;
          height: fit-content;
          align-items: center;
          justify-content: space-around;
          top: 0;
          flex-direction: row;
          position: fixed;
          z-index: 100;
          left: 2%;
        }
        #leftContainer h2{
          font-size: clamp(.9rem, 1.2vw, 1.2rem);
        }
        #leftContainer span{
          font-size: clamp(.8rem, 1vw, 1.2rem);
        }
        .Accesories{
          display: none;
        }
        #loginForm, #regForm{
          width: 100%;
        }
        .info-box{
          padding: 0;
        }
      }
    </style>
  </head>
  <body>
    <div class="banner">
      <div id="leftContainer">
        <h2 onclick="window.location.href='../Pages/'">TRINITY</h2>
        <span onclick="window.location.href='../Pages/'">Home</span>
        <span onclick="window.location.href='../Pages/products.php#product-section'">Collection</span>
        <span onclick="window.location.href='products.php?category=men'">Men</span>
        <span onclick="window.location.href='products.php?category=women'">Women</span>
        <span class="Accesories" onclick="window.location.href='products.php?category=accesories'">Accesories</span>
      </div>
      <form action="register.php" method="POST" id="regForm">
        <div class="info-box">
          <div class="brand-header">
            <h2>Register</h2>
            <p>Create new Trinity Account</p>
          </div>
          <div class="input-group">
            <input type="text" name="email" required />
            <label>Email</label>
          </div>
          <div class="input-group">
            <input type="password" name="user_password" required />
            <label>Password</label>
          </div>
          <span class="gender-label">Sex</span>
          <div class="gender-container">
            <div class="gender-box">
              <div class="male-front">Male</div>
              <input type="radio" value="male" name="user_sex" id="s-1" hidden>
              <label for="s-1" class="male-back" style="background-color: #3266ff">Male</label>
            </div>
            <div class="gender-box">
              <div class="male-front">Female</div>
              <input type="radio" value="female" name="user_sex" id="s-2" hidden>
              <label for="s-2" class="male-back" style="background-color: #ff00aa">
                Female
              </label>
            </div>
            <div class="gender-box">
              <div class="male-front">Other</div>
              <input type="radio" value="other" name="user_sex" id="s-3" hidden checked>
              <label for="s-3" class="male-back" style="background-color: #888">Other</label>
            </div>
          </div>
          <div class="input-group">
            <input type="text" name="user_hotline" required />
            <label>Hotline</label>
          </div>
          <button type="submit" class="btn-action">Create Account</button>
          <div class="login-link">
            Already have an account? <a href="#" id="login-btn" class="btn">Login</a>
          </div>
        </div>
      </form>

      <form action="login.php" method="POST" id="loginForm">
        <div class="info-box login-box">
          <div class="brand-header">
            <h2>Login</h2>
            <p>Welcome back</p>
          </div>
          <div class="input-group">
            <input type="text" name="username" required />
            <label>Email</label>
          </div>
          <div class="input-group">
            <input type="password" name="user_password" required />
            <label>Password</label>
          </div>
          <button type="submit" class="btn-action">Sign In</button>
          <div class="extra-link">
            <a href="#">Forget password?</a>
            <div class="login-link">
            Don't have an account yet? <a href="#" id="signUp-btn" class="btn">Sign Up</a>
          </div>
          </div>
        </div>
      </form>
    </div>
    <script>
      const select = document.querySelectorAll(".gender-box");
      select.forEach(sec =>{
        sec.addEventListener('click', ()=>{
          select.forEach(sec => sec.classList.remove("stay"));
          sec.classList.add("stay");
          const radio = sec.querySelector("input[type=radio]");
          radio.checked = true;
        });
      });

      document.querySelectorAll(".btn").forEach(button =>{
        button.addEventListener('click', ()=>{
          document.getElementById("loginForm").classList.toggle("move");
          document.getElementById("regForm").classList.toggle("move");
        });
      });

      document.querySelector('input[name="user_hotline"]').addEventListener("input", function(){
        this.value = this.value.replace(/\D/g, "").slice(0,10);
      });
    </script>
  </body>
</html>
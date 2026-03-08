<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

$username = $_SESSION['username'] ?? null;
$product = $conn
  ->query("SELECT * FROM products")
  ->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fashion-Web-Products</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet" 
    />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;700&display=swap" rel="stylesheet">
<style>
      html,
      body {
        user-select: none;
        top: 0;
        left: 0;
        position: relative;
        margin: auto;
        background-color: rgb(255, 255, 255);
        height: 100%;
        width: 100%;
        scroll-behavior: smooth;
      }
      /*section head - menu*/
      #head{
        position: relative;
        margin: auto;
        width: 100vw;
        height: 100svh;
        max-width: 1500px;
        max-height: 900px;
        top: 0;
      }




/*START MENU*/
#menu{
    width: 100vw;
    max-width: 1500px;
    margin-top: clamp(0.25rem, 1vw, 1rem);
    height: clamp(0.25rem, 2.5vw, 3rem);;
    display: flex;
    justify-content: space-around;
    align-items: center;
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5000;
}
#text-menu{
    width: 70%;
    height: 100%;
    display: flex;
    justify-content: start;
    align-items: center;
    position: relative;
    left: 0;
}
#logo{
    position: relative;
    left: 0;
    width: 10%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: rgb(255, 255, 255);
    font-size: clamp(.25rem, 3vw, 2.5rem);
    cursor: default;
}
#text{
    width: 60%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bolder;
}
#text span{
    color: orange;
    font-size: clamp(0.35rem, 1.25vw, 1rem);
}
#text span:hover{
    transition: .3s all;
    cursor: pointer;
    background-color: rgb(0, 0, 0);
    color: white;
}


#utility-menu{
    width: 20%;
    height: 100%;
    display: flex;
    justify-content: space-around;
    align-items: center;
    font-size: clamp(0.45rem, 1.25vw, 1rem);
}
.icon{
    width: clamp(.35rem, 1.25vw, 2.5rem);
    height: clamp(.35rem, 1.25vw, 2.5rem);
}
.icon path{
    scale: 1;
}
#login-btn{
    width: 30%;
    height: 80%;
    background-color: orangered;
    border-radius: 2px;
    text-align: center;
    color: white;
    align-items: center;
    display: flex;
    justify-content: center;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bolder;
    cursor: pointer;
}
#login-btn:hover{
    background-color: rgb(183, 49, 0);
}
#user-account{
    width: clamp(.25rem, 3vw, 2.5rem);
    height: clamp(.25rem, 3vw, 2.5rem);
    z-index: 2;
    background-color: #111;
    border-radius: 50%;
}
#user-avatar{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    object-position: center 30%;
}
/*Menu Button*/
.hamburger{
  cursor: pointer;
}
.hamburger input{
  display: none;
}
.hamburger svg{
  height: 2em;
  transition: transform 600ms cubic-bezier(0.4, 0, 0.2, 1);
}
.line{
  fill: none;
  stroke: rgb(0, 0, 0);
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-width: 3;
  transition: stroke-dasharray 600ms cubic-bezier(0.4, 0, 0.2, 1),
              stroke-dashoffset 600ms cubic-bezier(0.4, 0, 0.2, 1);
}
.line-top-bottom{
  stroke-dasharray: 12 63;
}
#menu-toggle:checked + #utility-menu .hamburger svg{
  transform: rotate(-45deg);
}

#menu-toggle:checked + #utility-menu .line-top-bottom{
  stroke-dasharray: 20 300;
  stroke-dashoffset: -32.42;
}

/*Menu Button*/
/*FAST MENU*/
#fast-menu{
    background: linear-gradient(180deg,#111 0%,#0a0a0a 50%,#0000005d 100%);
    color: #fff;
    position: fixed;
    width: 260px;
    top: 10%;
    right: 1%;
    transform: translate(200%, -50%);
    padding: 30px 40px;
    display: grid;
    gap: 30px;
    box-sizing: border-box;
    visibility: hidden;
    opacity: 0;
    border-radius: 12px 0 0 12px;
    box-shadow: -10px 0 30px rgba(0,0,0,0.5);
    transition: .4s ease;
    z-index: 5000;
}
#fast-menu.open{
  visibility: visible;
  opacity: 1;
  transform: translateX(0);
}
.menu-item:hover .menu-title{
    color: orangered;
    text-decoration: underline;
}
.menu-item:hover .submenu{
    color: white;
    text-decoration: none;
}
.menu-title{
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    border-bottom: 1px solid #ddd;
}
.sub-sub{
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    padding-left: 15px;
    transition: .3s ease;
}
.submenu-item.active .sub-sub{
    max-height: 100px;
    opacity: 1;
}
.submenu{
    max-height: 0;
    overflow: hidden;
    transition: .35s ease;
}

.menu-item.active .submenu{
    max-height: 300px;
}
/*FAST MENU*/
/*END MENU*/
      /*End section head - menu */

      /*Section head - banner */
      #banner {
        width: 100%;
        height: 100%;
      }
      #banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 10%;
        position: relative;
      }
      .introduct {
        width: 100%;
        max-height: 3px;
        font-family: "Times New Roman", Times, serif;
        font-size: 2.5rem;
        text-align: center;
        position: relative;
        display: flex;
        justify-content: center;
        padding-bottom: 5%;
      }
      .type_clothing {
        width: 100%;
        max-width: 1500px;
        height: 60%;
        position: relative;
        display: grid;
        place-items: center;
        margin: 10% auto;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        scroll-behavior: smooth;
      }
      .type_clothing div {
        width: 90%;
        height: 100%;
        background-color: #ffffcc;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        line-height: 1;
        transition: all 0.4s;
        cursor: pointer;
        margin-bottom: 100px;
      }
      .type_clothing svg {
        width: clamp(.25rem, 7vw, 5rem);
        height: clamp(.25rem, 7vw, 5rem);
        display: block;
        opacity: 0.8;
        margin: clamp(.25rem, 1vw, 2.5rem);
      }
      .type_clothing p {
        font-family: "Poppins", sans-serif;
        word-break: break-all;
        overflow-wrap: break-word;
        font-size: clamp(.25rem, 1.5vw, 2.5rem);
        letter-spacing: 0.5px;
        line-height: 1.6;
        color: #333;
        width: 80%;
        text-align: center;
        cursor: pointer;
      }
      .type_clothing div:hover {
        cursor: pointer;
        transition: all 0.4s;
        transform: translateY(-10px);
      }
      #body {
        width: 100%;
        max-width: 1500px;
        height: 100svh;
        max-height: 900px;
        position: relative;
        display: flex;
        justify-content: center;
        margin: auto;
        overflow: auto;
      }
      #body-products{
        width: 100%;
        height: 100%;
        overflow: auto;
        position: relative;
        top: 10%;
      }
      .men-fashion {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        place-items: center;
        margin: 0;
        overflow: auto;
      }
      .men-fashion-product {
        width: clamp(5rem, 31vw, 19rem);
        height: clamp(5rem, 33vw, 28rem);
        border: 1px solid black;
        border-radius: 5%;
        background-color: white;
        overflow: hidden;
        transition: .1s all;
      }
      .men-fashion-product:hover {
        transition: .3s all;
        scale: 1.05;
      }
      .men-fashion-product:hover img{
        filter: brightness(80%);
      }
      .product-image {
        width: 100%;
        height: clamp(5rem, 22vw, 20rem);
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
      }
      .product-price {
        width: 100px;
        height: 40px;
        border-radius: 10px;
        color: #b5835a;
        font-family: "Inter", sans-serif;
        font-weight: bolder;
        font-size: 17px;
        position: relative;
        left: 2%;
        line-height: 1.6;
        user-select: none;
        display: flex;
        justify-content: start;
        align-items: center;
      }
      .product-brand {
        letter-spacing: 4px;
        font-size: 12px;
        color: #999;
        margin-bottom: 10px;
        font-family: "Montserrat", serif;
        position: relative;
        left: 2%;
      }
      .product-name {
        font-family: "Montserrat", serif;
        font-weight: bold;
        font-size: 20px;
        position: relative;
        left: 2%;
      }
      .product-details {
        position: relative;
        display: inline-flex;
        width: 150px;
        height: 50px;
        background-color: white;
        border: 1px solid black;
        color: black;
        font-family: "Montserrat", serif;
        font-size: 15px;
        border-radius: 17px;
        gap: 15px;
        text-align: center;
        white-space: nowrap;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.4s;
      }
      .product-details span {
        position: absolute;
      }
      .product-details:hover {
        transition: 0.4s;
        transform: translateY(-5%);
      }
      .box {
        margin: 0 auto;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100px;
        height: 50px;
        background-color: black;
        color: white;
        border-radius: 15px;
      }
      .box:hover {
        cursor: pointer;
      }
      .product-cart {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        font-size: 30px;
        scale: 1.4;
        margin: 7px 15px;
        transition: 0.4s;
      }
      .product-cart:hover {
        filter: brightness(75%);
        transition: 0.4s;
        cursor: pointer;
      }
      .product-buy {
        font-size: 15px;
        color: white;
        font-family: "Montserrat", serif;
        font-weight: bold;
        position: absolute;
        right: 15px;
        top: 5px;
        cursor: pointer;
        transition: 0.4s;
      }
      .product-buy:hover {
        transition: 0.4s;
        filter: brightness(75%);
      }
      .woman-fashion {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        place-items: center;
        margin: 0;
        gap: 20px;
        margin-top: 10%;
      }
      .unisex-fashion {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        place-items: center;
        margin: 0;
        gap: 20px;
        margin-top: 10%;
      }
      .accessory-fashion {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        place-items: center;
        margin: 0;
        gap: 20px;
        margin-top: 10%;
      }




#product-modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.8);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 5000;
  backdrop-filter: blur(5px);
}

.modal-container {
  width: 900px;
  height: 550px;
  background: white;
  display: flex;
  animation: luxuryFade 0.4s ease;
  box-shadow: 0 40px 80px rgba(0,0,0,0.4);
}

.modal-left {
  width: 50%;
  background: #f5f5f5;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-left img {
  width: 80%;
  height: 80%;
  object-fit: contain;
}
#tooltip-explain{
  position: absolute;
  width: 150px;
  height: 70px;
  background-color: rgba(0, 0, 0, 0.65);
  margin: -100px 25px;
  visibility: hidden;
  opacity: 0;
  transition: .3s all;
  color: white;
  font-size: clamp(0.35rem, 0.7vw, 1rem); 
  text-align: center;
  font-family: "Montserrat", serif;
}
#Try-on-form:hover #tooltip-explain{
  visibility: visible;
  opacity: 1;
  transition: .3s all;
}
.modal-right {
  width: 50%;
  padding: 60px 40px;
  position: relative;
  font-family: "Montserrat", serif;
}

.close-modal {
  position: absolute;
  top: 20px;
  right: 25px;
  font-size: 28px;
  cursor: pointer;
  transition: 0.3s;
  transition: .1s all;
}

.close-modal:hover {
  transition: .3s all;
  transform: scale(1.3);
}

.modal-brand {
  letter-spacing: 4px;
  font-size: 12px;
  color: #999;
  margin-bottom: 10px;
}

#modal-name {
  font-size: 28px;
  font-weight: 600;
  margin-bottom: 20px;
}

#modal-price {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 40px;
}

.size-select p {
  font-size: 14px;
  margin-bottom: 10px;
}

.sizes {
  display: flex;
  gap: 15px;
  margin-bottom: 40px;
}

.sizes label {
  width: 40px;
  height: 40px;
  border: 1px solid black;
  display: grid;
  place-items: center;
  cursor: pointer;
  transition: 0.3s;
}

.sizes label:hover,
.sizes label.active {
  background: black;
  color: white;
}

.modal-add {
  width: 100%;
  height: 50px;
  background: black;
  color: white;
  border: none;
  letter-spacing: 2px;
  font-weight: 600;
  cursor: pointer;
  transition: 0.3s;
}

.modal-add:hover {
  background: #333;
}

@keyframes luxuryFade {
  from {opacity: 0; transform: translateY(40px);}
  to {opacity: 1; transform: translateY(0);}
}


@keyframes fadeIn {
  from {transform: scale(0.8); opacity: 0;}
  to {transform: scale(1); opacity: 1;}
}



#try-on-modal{
  width: 90%;
  height: 50%;
  max-width: 420px;
  padding: 30px;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 15px 50px rgba(0,0,0,0.25);
  display: flex;
  flex-direction: column;
  gap: 20px;
  align-items: center;
  font-family: "Montserrat", sans-serif;
  text-align: center;
  visibility: hidden;
  opacity: 0;
  transition: .35s;
  z-index: 5001;
}
#try-on-modal.show{
  visibility: visible;
  opacity: 1;
}
#try-on-modal h1{
  font-size: 20px;
  letter-spacing: 2px;
}
#try-on-modal label{
  width: 100%;
  padding: 35px 20px;
  border: 2px dashed #ccc;
  border-radius: 10px;
  cursor: pointer;
  font-size: 14px;
  color: #555;
  transition: .25s;
}
#try-on-modal label:hover{
  border-color: black;
  color: black;
}
.try-warning{
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 12px;
  color: #c40000;
  background: #fff5f5;
  border: 1px solid #ffd6d6;
  padding: 10px;
  border-radius: 6px;
}
.icon{
  width:18px;
  height:18px;
  fill:#c40000;
}
#try-on-modal button{
  width: 100%;
  padding: 12px;
  border: none;
  background: black;
  color: white;
  font-weight: 600;
  letter-spacing: 1px;
  cursor: pointer;
  transition: .25s;
}
#try-on-modal button:hover{
  background:#333;
}
#progress-container{
  color: black; 
  text-align: center;
}
#progress{
  width: 0%;
  height: 100%;
  background-color: black;
  transition: 3s all;
  color: black;
  text-align: center;
}


@media(max-width: 500px){
  #head{  
    height: 30%;
  }
  #banner img{
    object-fit: cover;
    scale: 1.05;
  }
  .type_clothing{
    top: 5%;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    width: 80%;
    gap: 10px;
  }
  .type_clothing div{
    height: 80%;
  }
}



#search-container{
  position: relative;
  margin: auto;
  display: grid;
  place-items: center;
  margin-top: 10%;
}
#search{
  position: relative;
  width: 30%;
  height: 100%;
}
#progress-container span{
  align-self: center;
}
#progress-container span.animation::after{
  animation: loadingText 3s infinite;
  content: "Loading model";
}
#animate{
  margin-left: 10%;
  width: 90%; 
  display: flex; 
  justify-content: end; 
  right: 0; 
  position: relative; 
  align-items: center;
}
#animate span{
    opacity: 0;
    transition: .3s all;
    font-family: 'Dancing Script', cursive;
}
#animate.animated span{
    animation: spanAnimate 1s forwards;
    animation-delay: 8s;
}
#cursor{
  position: absolute;
  transform: translate(400%, 500%);
  fill: black;
}
#animate.animated #cursor{
  animation: cursorAnimate 5s forwards;
}
#animate.animated #dresser{
    animation: dresserAnimate 1s forwards;
    animation-delay: 2.7s;
}
#cloth{
    display: flex;
    visibility: hidden;
    opacity: 0;
    scale: 0.8;
    position: absolute;
    fill: rgb(0, 0, 0);
}
#animate.animated #cloth{
    animation: clothAnimate 4s forwards;
    animation-delay: 4s;
}
#person{
    position: relative;
    right: 20%;
}
#animate.animated #person{
    animation: personAnimate 3.05s forwards;
    animation-delay: 5.9s;
}
@keyframes cursorAnimate {
  0%{
    position: absolute;
    transform: translate(400%, 500%);
  }50%{
    position: absolute;
    transform: translate(0%, 50%);
  }50.1%{
    scale: 1;
    position: absolute;
    transform: translate(0%, 50%);
  }51%{
    scale: 1.1;
    position: absolute;
    transform: translate(0%, 50%);
  }52%{
    scale: 1;
    position: absolute;
    transform: translate(0%, 50%);
  }
  100%{
    scale: 1;
    position: absolute;
    transform: translate(0%, 50%);
  }
}
@keyframes dresserAnimate {
    0%{
        scale: 1.1;
    }100%{
        scale: 1;
    }
}
@keyframes clothAnimate {
    0%{
        visibility: visible;
        opacity: 1;
    }50%{
        visibility: visible;
        opacity: 1;
        transform: translateX(-510%);
    }100%{
        visibility: visible;
        opacity: 1;
        transform: translateX(-640%);
    }
}
@keyframes personAnimate {
    0%{
        fill: rgb(0, 0, 0);
    }80%,100%{
        transform: translateX(-100%);
    }
}
@keyframes spanAnimate {
    0%{
        opacity: 0;
    }100%{
        opacity: 1;
    }
}
@keyframes loadingText {
  0%{
    content: "Loading model";
  }30%{
    content: "Loading model."
  }60%{
    content: "Loading model..";
  }100%{
    content: "Loading model...";
  }
}
</style>
  </head>
  <body>
    <!--HEADER-->
    
    <section id="head">
      <section id="menu">
        <div id="text-menu">
          <div id="logo" onclick="window.location.href='../Pages/'">T</div>
          <div id="text">
            <span>New Arrival</span>
            <span>Tops</span>
            <span>Bottoms</span>
            <span>Accesorires</span>
            <span>About</span>
          </div>
        </div>  
        <input type="checkbox" id="menu-toggle" hidden>
        <div id="utility-menu">
          <label class="hamburger" for="menu-toggle">
                    <svg viewBox="0 0 32 32">
                        <path class="line line-top-bottom" d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"></path>
                        <path class="line" d="M7 16 27 16"></path>
                    </svg>
          </label>
          <svg class="icon" viewBox="0 0 640 512" aria-hidden="true" onclick="window.location.href='cart.php'">
            <path
              fill="currentColor"
              d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"
            />
          </svg>
          <?php if(isset($_SESSION['username'])): ?>
                <p onclick="window.location.href='user.php'"><?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account" onclick="window.location.href='user.php'">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div id="login-btn">
                    <form action="../Pages/log.php" method="post" style="width: 100%; height: 100%;">
                        <input type="submit" value="Login" style="width: 100%; height: 100%; background-color: transparent; border: none; color: white;">
                    </form>
                </div>
            <?php endif; ?>
        </div>
      </section>
<div id="fast-menu">
    <div class="menu-item">
        <div class="menu-title">TRINITY</div>
            <div class="submenu">
                <div class="submenu-item">T-shirt
                  <div class="sub-sub search-item">Basic T-shirt</div>
                  <div class="sub-sub search-item">Oversize T-shirt</div>
            </div>
            <div class="submenu-item">Polo shirt
                  <div class="sub-sub search-item">Basic Polo</div>
                  <div class="sub-sub search-item">Logo Polo</div>
            </div>
            <div class="submenu-item">Hoodie
                  <div class="sub-sub search-item">Basic Hoodie</div>
                  <div class="sub-sub search-item">Logo Hoodie</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY LADIES</div>
        <div class="submenu">
            <div class="submenu-item">T-shirt
                  <div class="sub-sub search-item">Basic T-shirt</div>
                  <div class="sub-sub search-item">Oversize T-shirt</div>
            </div>
            <div class="submenu-item">Blouse
                  <div class="sub-sub search-item">Classic Blouse</div>
                  <div class="sub-sub search-item">Wrap Blouse</div>
            </div>
            <div class="submenu-item">Crop top
                  <div class="sub-sub search-item">Basic Crop Top</div>
                  <div class="sub-sub search-item">Tank Crop Top</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">GIFT VOUNCHER</div>
        <div class="submenu">
            <div>Check voucher</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY TIER</div>
        <div class="submenu">
            <div>Check your shopping tier</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">ABOUT</div>
    </div>
</div>
      <section id="banner">
        <img src="..\Pictures\Banners\banner_product.png" alt="" />
      </section>
    </section>
<section class="type_clothing">
        <div onclick="scrollinto()" class="men">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
            <path
              d="M320 32c0-17.7 14.3-32 32-32L480 0c17.7 0 32 14.3 32 32l0 128c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-50.7-95 95c19.5 28.4 31 62.7 31 99.8 0 97.2-78.8 176-176 176S32 401.2 32 304 110.8 128 208 128c37 0 71.4 11.4 99.8 31l95-95-50.7 0c-17.7 0-32-14.3-32-32zM208 416a112 112 0 1 0 0-224 112 112 0 1 0 0 224z"
            />
          </svg>
          <p>
            Refined tailoring crafted for the modern gentleman — where strength
            meets understated elegance.
          </p>
        </div>
        <div onclick="document.querySelector('.woman-fashion').scrollIntoView({behavior: 'smooth', block: 'center'})" class="woman">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 515 512">
            <!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
            <path
              d="M80 176a112 112 0 1 1 224 0 112 112 0 1 1 -224 0zM223.9 349.1C305.9 334.1 368 262.3 368 176 368 78.8 289.2 0 192 0S16 78.8 16 176c0 86.3 62.1 158.1 144.1 173.1-.1 1-.1 1.9-.1 2.9l0 64-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 0 32c0 17.7 14.3 32 32 32s32-14.3 32-32l0-32 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-64c0-1 0-1.9-.1-2.9z"
            />
          </svg>
          <p>
            Grace in every silhouette, designed to celebrate confidence, poise,
            and timeless beauty.
          </p>
        </div>
        <div onclick="document.querySelector('.unisex-fashion').scrollIntoView({behavior: 'smooth', block: 'center'})" class="unisex">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -64 640 576">
            <!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
            <path
              d="M480-64c-17.7 0-32 14.3-32 32S462.3 0 480 0L530.7 0 474 56.7c-26.3-15.7-57.1-24.7-90-24.7-35.4 0-68.4 10.5-96 28.5-27.6-18-60.6-28.5-96-28.5-97.2 0-176 78.8-176 176 0 86.3 62.1 158.1 144 173.1l0 34.9-32 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 0 32c0 17.7 14.3 32 32 32s32-14.3 32-32l0-32 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-32 0 0-34.9c23.3-4.3 44.9-13.1 64-25.6 27.6 18 60.6 28.5 96 28.5 97.2 0 176-78.8 176-176 0-41.1-14.1-79-37.8-109L576 45.3 576 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-128c0-17.7-14.3-32-32-32L480-64zM336 309.2c20.2-28.6 32-63.5 32-101.2s-11.8-72.6-32-101.2c14.6-6.9 30.8-10.8 48-10.8 61.9 0 112 50.1 112 112S445.9 320 384 320c-17.2 0-33.5-3.9-48-10.8zM288 150.3c10.2 16.9 16 36.6 16 57.7s-5.8 40.9-16 57.7c-10.2-16.9-16-36.6-16-57.7s5.8-40.9 16-57.7zm-48-43.5c-20.2 28.6-32 63.5-32 101.2s11.8 72.6 32 101.2c-14.5 6.9-30.8 10.8-48 10.8-61.9 0-112-50.1-112-112S130.1 96 192 96c17.2 0 33.5 3.9 48 10.8z"
            />
          </svg>
          <p>
            Fluid design beyond boundaries — effortless style made for every
            identity.
          </p>
        </div>
        <div onclick="document.querySelector('.accessory-fashion').scrollIntoView({behavior: 'smooth', block: 'center'})" class="accessory">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
            <!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
            <path
              d="M182.2 76.1L130.8 307.5C145.5 324.9 167.4 336 192 336l256 0c24.6 0 46.5-11.1 61.2-28.5L457.8 76.1c-5.7-25.8-28.6-44.1-55-44.1-12.2 0-24.1 4-33.8 11.3l-4.7 3.5c-26.3 19.7-62.4 19.7-88.6 0L271 43.3c-9.8-7.3-21.6-11.3-33.8-11.3-26.4 0-49.3 18.3-55 44.1zM64 256c0-17.7-14.3-32-32-32S0 238.3 0 256C0 362 86 448 192 448l256 0c106 0 192-86 192-192 0-17.7-14.3-32-32-32s-32 14.3-32 32c0 70.7-57.3 128-128 128l-256 0c-70.7 0-128-57.3-128-128z"
            />
          </svg>
          <p>
            Elevated details that complete the statement — subtle accents,
            undeniable impact.
          </p>
        </div>
    </section>
    <div id="search-container">
      <h1>Search By Name</h1>
      <input type="text" id="search">
    </div>
    
    <!--BODY-->

    <section id="body"> 
      <section id="body-products">
        <p class="introduct">
        <span>&ndash;&ndash;&ndash;Newest Collections&ndash;&ndash;&ndash;</span>
    </p>
        <section class="men-fashion" id="newest">
          <?php if(empty($product)): ?>
            Nothing in this field
          <?php else: ?>
            <?php foreach($product as $p): ?>
              <?php if($p['product_category'] == "collections"): ?>
          <div class="men-fashion-product"  data-id="<?= $p['id'] ?>"
                                            data-name="<?= htmlspecialchars($p['product_name']) ?>"
                                            data-price="<?= htmlspecialchars($p['product_price']) ?>"
                                            data-img="../<?= htmlspecialchars($p['product_img']) ?>">
            <div class="product-image" style="background-image: url(../<?=$p['product_img']?>);"></div>
            <div class="product-price"><?=$p['product_price']?>$</div>
            <div class="product-brand">TRINITY</div>
            <div class="product-name"><?=$p['product_name']?></div>
          </div>
          <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>
        <p class="introduct">
        <span>&ndash;&ndash;&ndash;Men Fashion&ndash;&ndash;&ndash;</span>
      </p>
        <section class="woman-fashion">
          <?php if(empty($product)): ?>
            Nothing in this field
          <?php else: ?>
            <?php foreach($product as $p): ?>
              <?php if($p['product_category'] == "men"): ?>
          <div class="men-fashion-product"  data-id="<?= $p['id'] ?>"
                                            data-name="<?= htmlspecialchars($p['product_name']) ?>"
                                            data-price="<?= htmlspecialchars($p['product_price']) ?>"
                                            data-img="../<?= htmlspecialchars($p['product_img']) ?>">
            <div class="product-image" style="background-image: url(../<?=$p['product_img']?>);"></div>
            <div class="product-price"><?=$p['product_price']?>$</div>
            <p class="product-brand">TRINITY</p>
            <div class="product-name"><?=$p['product_name']?></div>
          </div>
          <?php endif; ?>
            <?php endforeach; ?>  
          <?php endif; ?>
        </section>
        <p class="introduct">
        <span>&ndash;&ndash;&ndash;Ladies Fashion&ndash;&ndash;&ndash;</span>
      </p>
        <section class="unisex-fashion">
          <?php if(empty($product)): ?>
            Nothing in this field
          <?php else: ?>
            <?php foreach($product as $p): ?>
              <?php if($p['product_category'] == "women"): ?>
          <div class="men-fashion-product" data-id="<?= $p['id'] ?>"
                                           data-name="<?= htmlspecialchars($p['product_name']) ?>"
                                           data-price="<?= htmlspecialchars($p['product_price']) ?>"
                                           data-img="../<?= htmlspecialchars($p['product_img']) ?>">
            <div class="product-image" style="background-image: url(../<?=$p['product_img']?>);"></div>
            <div class="product-price"><?=$p['product_price']?>$</div>
            <div class="product-brand">Trinity</div>
            <div class="product-name"><?=$p['product_name']?></div>
          </div>
          <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>
        <p class="introduct">
        <span>&ndash;&ndash;&ndash;&ndash;</span> Accessory
        <span>&ndash;&ndash;&ndash;&ndash;</span>
      </p>
        <section class="accessory-fashion">
          <?php if(empty($product)): ?>
            Nothing in this field
          <?php else: ?>
            <?php foreach($product as $p): ?>
              <?php if($p['product_category'] == "accesories"): ?>
          <div class="men-fashion-product"  data-id="<?= $p['id'] ?>"
                                            data-name="<?= htmlspecialchars($p['product_name'])?>"
                                            data-price="<?= htmlspecialchars($p['product_price'])?>"
                                            data-img="../picture-uploads/<?= htmlspecialchars($p['product_img'])?>">>
            <div class="product-image" style="background-image: url(../picture-uploads/<?=$p['product_img']?>);"></div>
            <div class="product-price"><?=$p['product_price']?>$</div>
            <div class="product-brand">Trinity</div>
            <div class="product-name"><?=$p['product_name']?></div>
          </div>
          </div>
          <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>
      </section>
    </section>
    <!--FOOT-->

<section id="foot"></section>
<div id="product-modal">
  <div class="modal-container">
    <div class="modal-left">
      <form action="" method="POST" style="align-self: end; left: 80%; position: relative;" id="Try-on-form">
        <h1 style="width: 20px; height: 20px; display: grid; place-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
          <path d="M320.2 112c44.2 0 80-35.8 80-80l53.5 0c17 0 33.3 6.7 45.3 18.7L617.6 169.4c12.5 12.5 12.5 32.8 0 45.3l-50.7 50.7c-12.5 12.5-32.8 12.5-45.3 0l-41.4-41.4 0 224c0 35.3-28.7 64-64 64l-192 0c-35.3 0-64-28.7-64-64l0-224-41.4 41.4c-12.5 12.5-32.8 12.5-45.3 0L22.9 214.6c-12.5-12.5-12.5-32.8 0-45.3L141.5 50.7c12-12 28.3-18.7 45.3-18.7l53.5 0c0 44.2 35.8 80 80 80z"/>
        </svg>
        </h1>
        <div id="tooltip-explain">
          <h3>Virtual AI Try On</h3>
          <span>This is an experiment feature for customers to try on our product</span>
        </div>
      </form>
      <img id="modal-img" src="" alt="">
    </div>
    <div class="modal-right">
      <span class="close-modal">&times;</span>
      <p class="modal-brand">TRINITY</p>
      <h2 id="modal-name"></h2>
      <p id="modal-price"></p>
      <div class="size-select">
        <p>Size</p>
        <div class="sizes">      
          <label for="S-size-<?=$p['id']?>">S</label>
          <label for="M-size-<?=$p['id']?>">M</label>        
          <label for="L-size-<?=$p['id']?>">L</label>        
          <label for="XL-size-<?=$p['id']?>">XL</label>
        </div>
      </div>
          <form action="../Database/add_item_to_cart.php" method="POST" style="width: 100%; display: grid; place-items: center;">     
                    <input type="hidden" name="product_id" value="<?=$p['id']?>" id="modal-product-id">
                    <input type="hidden" name="product_name" value="<?=$p['product_name']?>" id="modal-product-name">
                    <input type="hidden" name="product_category" value="<?=$p['product_category']?>" id="modal-product-type">
                    <input type="hidden" name="product_color" value="<?=$p['product_color']?>" id="modal-product-color">
                    <input type="radio" name="cart_size" value="S" id="S-size-<?=$p['id']?>" hidden checked>
                    <input type="radio" name="cart_size" value="M" id="M-size-<?=$p['id']?>" hidden>
                    <input type="radio" name="cart_size" value="L" id="L-size-<?=$p['id']?>" hidden>
                    <input type="radio" name="cart_size" value="XL" id="XL-size-<?=$p['id']?>" hidden>       
                    <button class="modal-add add-cart-btn-big" type="submit">ADD TO CART</button>
            </form>
      <div id="modal-detail" onclick="window.location.href='detail.php?id=<?=$p['id']?>'">Details</div>
    </div>
  </div>
</div>
<div id="try-on-modal">
  <h1>VIRTUAL TRY ON AI</h1>
  <form id="tryon-form" action="http://127.0.0.1:5000/api/generate" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="username" value="<?=$_SESSION['username']?>">
    <input type="file" id="try-on-input" name="person" hidden>
    <input type="hidden" name="cloth" id="cloth">
    <label for="try-on-input">Choose your file</label>
    <h3 style="display: grid; place-items: center; position: absolute; bottom: 0; left: 5%">
      <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path d="M256 0c14.7 0 28.2 8.1 35.2 21l216 400c6.7 12.4 6.4 27.4-.8 39.5S486.1 480 472 480L40 480c-14.1 0-27.2-7.4-34.4-19.5s-7.5-27.1-.8-39.5l216-400c7-12.9 20.5-21 35.2-21zm0 352a32 32 0 1 0 0 64 32 32 0 1 0 0-64zm0-192c-18.2 0-32.7 15.5-31.4 33.7l7.4 104c.9 12.5 11.4 22.3 23.9 22.3 12.6 0 23-9.7 23.9-22.3l7.4-104c1.3-18.2-13.1-33.7-31.4-33.7z"/>
      </svg>
      <span style="color: red;">This is just an experiment feature, AI can make mistake and the result not always at ease!</span>
    </h3>
    <button type="submit">Generate</button>
  </form>
  <div id="progress-container" style="display: none; width: 100%; height: 10%; border: 1px solid black;">
    <span style="position: absolute;"></span>
    <div id="animate">
        <span>Trinity</span>
      <svg id="person" xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 0 384 512"><path d="M248 24a56 56 0 1 0 -112 0 56 56 0 1 0 112 0zm24 212.7l46.3 62.4c10.5 14.2 30.6 17.2 44.8 6.6s17.2-30.6 6.6-44.8l-70.5-95C274 132 234.3 112 192 112s-82 20-107.2 53.9l-70.5 95c-10.5 14.2-7.6 34.2 6.6 44.8s34.2 7.6 44.8-6.6L112 236.7 112 512c0 17.7 14.3 32 32 32s32-14.3 32-32l0-160c0-8.8 7.2-16 16-16s16 7.2 16 16l0 160c0 17.7 14.3 32 32 32s32-14.3 32-32l0-275.3z"/></svg>
      <svg id="cloth" xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 0 640 512"><path d="M320.2 112c44.2 0 80-35.8 80-80l53.5 0c17 0 33.3 6.7 45.3 18.7L617.6 169.4c12.5 12.5 12.5 32.8 0 45.3l-50.7 50.7c-12.5 12.5-32.8 12.5-45.3 0l-41.4-41.4 0 224c0 35.3-28.7 64-64 64l-192 0c-35.3 0-64-28.7-64-64l0-224-41.4 41.4c-12.5 12.5-32.8 12.5-45.3 0L22.9 214.6c-12.5-12.5-12.5-32.8 0-45.3L141.5 50.7c12-12 28.3-18.7 45.3-18.7l53.5 0c0 44.2 35.8 80 80 80z"/></svg>
    <svg id="dresser" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M160-120v-640q0-33 23.5-56.5T240-840h480q33 0 56.5 23.5T800-760v640h-80v-80H240v80h-80Zm80-400h200v-240H240v240Zm280-160h200v-80H520v80Zm0 160h200v-80H520v80ZM400-320h160v-80H400v80ZM240-440v160h480v-160H240Zm0 0v160-160Z"/></svg>
    <svg id="cursor" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m320-410 79-110h170L320-716v306ZM551-80 406-392 240-160v-720l560 440H516l144 309-109 51ZM399-520Z"/></svg>
    </div>
    <div id="progress"></div>
  </div>
</div>
<script>
const isLogin = <?= isset($_SESSION['username']) ? 'true' : 'false' ?>;
const products = document.querySelectorAll(".men-fashion-product");
const modal = document.getElementById("product-modal");
const modalImg = document.getElementById("modal-img");
const modalName = document.getElementById("modal-name");
const modalPrice = document.getElementById("modal-price");
const closeBtn = document.querySelector(".close-modal");
const modalProductId = document.getElementById("modal-product-id");
const modalProductName = document.getElementById("modal-product-name");
const modalProductType = document.getElementById("modal-product-type");
const modalProductColor = document.getElementById("modal-product-color");
const modalProductSize = document.getElementById("modal-product-size");
const try_on = document.getElementById("Try-on-form");
const try_on_modal = document.getElementById("try-on-modal");
const try_on_input = document.getElementById("cloth");
const search = document.getElementById("search");
const items = document.querySelectorAll(".men-fashion-product");
const addCart = document.querySelectorAll(".add-cart-btn-big");
const sizeAdd = document.querySelectorAll(".sizes label");

sizeAdd.forEach(label =>
  label.addEventListener('click', ()=>{
    sizeAdd.forEach(label =>{
      label.style.color = "black";
      label.style.background = "white";
    })
    label.style.color = "white";
    label.style.background = "black";
  })
)

addCart.forEach(btn =>{
  btn.addEventListener('click', function(e){
    if(!isLogin){
      const goLogin = confirm("Please login first!");
      if(!goLogin){
        e.preventDefault();
        return;
    }
    }
  });
});

search.addEventListener('input', ()=>{
  const keyword = search.value.toLowerCase();
    items.forEach(item =>{
      const search = item.textContent.toLowerCase();
        if(search.includes(keyword)){
          item.style.display = "";
        }else{
          item.style.display = "none";
        }
    });
});


document.querySelectorAll(".search-item").forEach(item =>{
  item.addEventListener("click", function (){
    let keyword = this.innerText.trim();
    let search = document.getElementById("search");
    search.value = keyword;
    search.dispatchEvent(new Event("input"));
    search.scrollIntoView({ behavior: "smooth" });
  });
});



//PRODUCT POP-UP
products.forEach(product => {
  product.addEventListener("click", function(e){
    if(e.target.closest(".box")) return;
    modalImg.src = this.dataset.img;
    modalName.textContent = this.dataset.name;
    modalPrice.textContent = this.dataset.price + "$";
    try_on_input.value = this.dataset.img;
    modal.style.display = "flex";
  });
});
closeBtn.onclick = () => modal.style.display = "none";
window.onclick = (e) =>{
  if(e.target === modal){
    modal.style.display = "none";
  }
};



//PRODUCT INFO - (LOGIN CHECK)
const detailBtn = document.getElementById("modal-detail");
let currentProductId = null;

if(isLogin){
products.forEach(product => {
  product.addEventListener("click", function(e){
    if(e.target.closest(".box")) return;
    modalImg.src = this.dataset.img;
    modalName.textContent = this.dataset.name;
    modalPrice.textContent = this.dataset.price + "$";
    modalProductId.value = this.dataset.id;
    modalProductName.value = this.dataset.name;
    modalProductType.value = this.dataset.type;
    modalProductType.value = this.dataset.color;
    currentProductId = this.dataset.id;
    modal.style.display = "flex";
  });
});
}
detailBtn.onclick = function(){
  if(currentProductId){
    window.location.href = "detail.php?id=" + currentProductId;
  }
};




//TRY ON AI - MODAL CONTROL (LOGIN CHECK)
try_on.addEventListener('click', (e)=>{
  if(!isLogin){
      const goLogin = confirm("Please login first!");
      if(goLogin)
        window.location.href="log.php";
      else if(!goLogin){
        e.preventDefault();
        return;
    }
}else if(isLogin){
    try_on_modal.classList.toggle("show");
}
});
document.addEventListener('click', (e) =>{
  if(!try_on_modal.contains(e.target)){
    if(try_on_modal.classList.contains("show") && !try_on.contains(e.target)){
      console.log("a");
      try_on_modal.classList.remove("show");
    }
  }
});




//RELOAD PAGE
window.addEventListener("load", function (){
    if(window.location.hash){

        const element = document.querySelector(window.location.hash);
        if(element){
            element.scrollIntoView({ behavior: "smooth" });
        }
        history.replaceState(null, null, window.location.pathname);
    }
});




//FAST MENU 
const menuTitles = document.querySelectorAll(".menu-title");
  menuTitles.forEach(title =>{
    title.addEventListener("click", ()=>{
      const parent = title.parentElement;
      parent.classList.toggle("active");
  });
        });
const submenuItems = document.querySelectorAll(".submenu-item");
  submenuItems.forEach(item =>{
      item.addEventListener("click",(e)=>{
          e.stopPropagation();
          item.classList.toggle("active");
      });
  });
const menu = document.getElementById("menu-toggle");
  menu.addEventListener('click', ()=>{
      document.getElementById("fast-menu").classList.toggle("open");
  });




//SUBMIT BY JS (BLOCK SUBMIT HTML FOR OTHER USE)
const form = document.querySelector("#tryon-form");
form.addEventListener("submit", async function(e){
    e.preventDefault();
    document.getElementById("progress-container").style.display = "flex";
    const formData = new FormData(this);
    const res = await fetch("http://127.0.0.1:5000/api/generate", {
        method: "POST",
        body: formData
    });
    const data = await res.json(e);
    if(data.status === "success"){
      const goUser = confirm("Redirect to user page for result?");
      if(goUser){
        window.location.href = data.redirect;
      }
    }
});


//PROGRESS BAR
const username = <?php echo json_encode($username); ?>;
let abc = 0;
let animationInterval = null;

setInterval(async () => {
  const res = await fetch(`http://localhost:5000/api/progress/${username}`);
  const data = await res.json();

  if (data.progress < 2) {

    document.querySelector("#progress-container span")
      .classList.add("animation");

    if (!animationInterval) {
      animationInterval = setInterval(() => {
        abc++;
        if (abc == 1) {
          document.getElementById("animate").style.opacity = "1";
          document.getElementById("animate").classList.add("animated");
        } else if (abc > 12) {
          document.getElementById("animate").style.opacity = "0";
          document.getElementById("animate").classList.remove("animated");
          abc = 0;
        }
      }, 1000);
    }

  } 
  else if (data.progress > 2) {

    document.getElementById("progress").style.width =
      `${data.progress + data.progress / 4.75}%`;

    document.querySelector("#progress-container span")
      .classList.remove("animation");

    document.getElementById("animate").classList.remove("animated");
    document.getElementById("animate").style.display = "none";

    if (animationInterval) {
      clearInterval(animationInterval);
      animationInterval = null;
    }
  }

}, 10000);

</script>
  </body>
</html>

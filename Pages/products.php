<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();
$username = $_SESSION['username'] ?? null;

$product = $conn
  ->query("SELECT * FROM products")
  ->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
    <style>
      html,
      body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        box-sizing: border-box;
        width: 100vw;
        height: 100vh;
        overflow-x: hidden;
        scroll-behavior: smooth;
        user-select: none;
      }
#menu{
    width: 100%;
    max-width: 1500px;
    height: 70px;
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 60px;
    background:rgba(255,255,255,0.6);
    backdrop-filter:blur(10px);
    z-index: 10;
}
#text span{
    position:relative;
    cursor:pointer;
}

#text span::after{
    content:"";
    position:absolute;
    left:0;
    bottom:-4px;
    width:0;
    height:2px;
    background:black;
    transition:0.3s;
}

#text span:hover::after{
    width:100%;
}
#text-menu{
    width: 70%;
    height: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    left: 0;
}
#logo{
    position: relative;
    left: 2%;
    width: 10%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-family: "Montserrat", serif;
    color: rgb(0, 0, 0);
    font-size: clamp(.25rem, 1.75vw, 2.5rem);
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
    width: clamp(.35rem, 1.25vw, 1.9rem);
    height: clamp(.35rem, 1.25vw, 1.9rem);
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
#menu-toggle:checked ~ #fast-menu{
    visibility: visible;
    opacity: 1;
    transform: translateX(0);
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
    top: 110%;
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
}
.menu-item:hover .menu-title{
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
.sub-sub:hover{
    text-decoration: underline;
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
      .head {
        position: relative;
        inset: 0;
        width: 100%;
        height: auto;
        flex-direction: row;
      }
      .banner {
        width: 100%;
        max-width: 1500px;
        max-height: 700px;
        height: 100svh;
        display: flex;
        overflow: hidden;
        position: relative;
        margin: auto;
        background-color: #fff;
      }

      .banner-left {
        width: 40%;
        height: 100%;
        background-color: #f5f1e8;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 0 5%;
        z-index: 2;
        clip-path: polygon(0 0, 100% 0, 85% 50%, 100% 100%, 0 100%);
      }

      .banner-right {
        width: 65%;
        height: 100%;
        position: absolute;
        right: 0;
        top: 0;
        background-image: url("../Pictures/Banners/banner-products.png");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        z-index: 1;
      }

      .banner-content .sub-title {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #e1c140;
        margin-bottom: 10px;
        font-weight: 600;
      }

      .banner-content h1 {
        font-size: 4rem;
        font-family: "Playfair Display", serif;
        line-height: 1.1;
        margin: 0 0 20px 0;
        color: #222;
      }

      .banner-content .description {
        font-size: 16px;
        color: #666;
        max-width: 80%;
        margin-bottom: 30px;
        line-height: 1.6;
      }

      .btn-shop {
        padding: 12px 35px;
        background-color: #222;
        color: #fff;
        text-decoration: none;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        transition: 0.3s;
        scroll-behavior: smooth;
        border: 2px solid #ffdeac;
      }

      .btn-shop:hover {
        background-color: transparent;
        color: #ffe79d;
      }
      .product-section {
        padding: 80px 0;
        background-color: #ffffff;
        font-family: Arial, sans-serif;
      }

      .product-collection{
        text-align: center;
        margin-bottom: 50px;
      }
      .product-collection .product-container{
        display: grid;
        place-items: center;
        grid-template-columns: repeat(3, 1fr);
      }

      .product-header {
        text-align: center;
        margin-bottom: 50px;
      }

      .product-subtitle {
        text-transform: uppercase;
        letter-spacing: 3px;
        font-size: 12px;
        color: #c5a059;
        margin-bottom: 10px;
      }

      .product-title {
        font-size: 32px;
        font-weight: normal;
        margin-bottom: 15px;
        color: #111;
      }

      .line {
        width: 40px;
        height: 2px;
        background-color: #111;
        margin: 0 auto;
      }

      .product-container {
        display: grid;
        justify-content: center;
        gap: 30px;
        padding: 60px 20px;
        font-family: Arial, sans-serif;
        max-width: 1300px;
        margin: 0 auto;
        grid-template-columns: repeat(4, 1fr);
      }
      @media (max-width: 1200px) {
        .product-container {
          grid-template-columns: repeat(3, 1fr);
        }
      }

      @media (max-width: 992px) {
        .product-container {
          grid-template-columns: repeat(2, 1fr);
          gap: 20px;
        }
      }

      @media (max-width: 576px) {
        .product-container {
          grid-template-columns: 1fr;
          padding: 40px 15px;
        }

        .product-card {
          max-width: 320px;
        }
      }
      .product-card {
        width: 280px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        transition: 0.3s;
      }

      .product-card:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-10px);
      }

      .image-box {
        width: 100%;
        height: 350px;
        position: relative;
        overflow: hidden;
      }

      .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
      }

      .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: 0.3s;
      }

      .product-card:hover .image-overlay {
        opacity: 1;
      }

      .product-card:hover .image-box img {
        transform: scale(1.1);
      }

      .details-btn {
        padding: 10px 20px;
        background: #000;
        color: #fff;
        border: none;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        cursor: pointer;
        transition: 0.4s;
      }
      .details-btn:hover {
        background: #fff;
        color: #000;
        border: 1px solid black;
      }
      .info-box {
        padding: 20px;
        text-align: center;
      }

      .brand {
        font-size: 10px;
        color: #c5a059;
        letter-spacing: 2px;
        text-transform: uppercase;
      }

      .title {
        font-size: 18px;
        margin: 10px 0;
        font-weight: normal;
        color: #1a1a1a;
      }

      .price-wrapper {
        margin-bottom: 20px;
      }

      .new-price {
        font-weight: bold;
        font-size: 16px;
      }

      .old-price {
        color: #888;
        text-decoration: line-through;
        margin-left: 10px;
        font-size: 14px;
      }

      .add-to-cart-btn {
        width: 100%;
        padding: 12px;
        background: #000;
        color: #fff;
        border: 1px solid #000;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        cursor: pointer;
        transition: 0.3s;
      }

      .add-to-cart-btn:hover {
        background: #fff;
        color: #000;
      }

      .wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fff;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      }

      .wishlist-btn:hover {
        color: #e74c3c;
      }
      .details-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(8px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s;
      }
      .active {
        opacity: 1;
        visibility: visible;
      }
      .details {
        width: 800px;
        height: 500px;
        background-color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        transition: all 0.4s;
      }
#product-modal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.8);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 101;
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
  width: 50%;
  height: 70%;
  max-width: 400px;
  max-height: 700px;
  z-index: 5001;
  background-color: white;
  position: fixed;
  bottom: 15%;
  left: 60%;
  translate: -50%;
  border: 1px solid black;
  text-align: center;
  display: flex; 
  flex-direction: column;
  justify-content: start;
  align-items: center;
  visibility: hidden;
  opacity: 0;
  transition: .3s all;
  font-family: "Montserrat", serif;
  z-index: 103;
}
#try-on-modal.show{
  visibility: visible;
  opacity: 1;
  transition: .3s all;
}
#alertNotice{
  width: 80vw;
  max-width: 400px;
  height: clamp(5rem, 22vh, 12rem);
  background: white;
  box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.8);
  position: fixed;
  left: 50%;
  transform: translate(-50%, -100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0;
  opacity: 0;
  visibility: hidden;
  transition: .3s all;
  z-index: 9999;
}
#alertNotice.tryon{
  opacity: 1;
  visibility: visible;
  transform: translate(-50%, 20%);
  transition: .3s all;
}
#alertNotice.tryon-close{
  display: flex; 
  justify-content: start;
  max-width: 80px;
  max-height: 40px;
  opacity: 1;
  visibility: visible;
  left: 0;
  transform: translate(0, 170%);
  transition: .3s all;
}
#alertNotice.tryon-close *{
  opacity: 0;
}
#closeAlertBtn{
  position: absolute;
  right: 0;
  border: none;
  background: transparent;
  transition: .1s all;
  font-size: clamp(1rem, 1.5vw, 2rem);
  opacity: 0;
  visibility: hidden;
}
#closeAlertBtn:hover{
  scale: 1.1;
  transition: .3s all;
}
#alertNotice.tryon #closeAlertBtn{
  opacity: 1;
  visibility: visible;
}
#alertNotice h4{
  font-family: Arial, Helvetica, sans-serif;
  font-weight: 600;
  position: relative;
  text-align: center;
  display: flex;
  justify-content: center;
  font-size: clamp(.6rem, 1vw, 2.25rem);
}
#alertNotice span{
  font-family: Arial, Helvetica, sans-serif;
  position: relative;
  text-align: center;
  font-size: clamp(.5rem, 1vw, 2rem);
}
#alertNotice.alert{
  opacity: 1;
  visibility: visible;
  transform: translate(-50%, 40%);
  transition: .3s all;
}
#alert-div{
  align-self: end;
  position: absolute;
  display: flex;
  gap: 3px;
  bottom: 5%;
  margin-right: 20px;
}
#CANCEL-btn{
  width: clamp(3rem, 6.3vw, 6rem);
  height: clamp(1rem, 3.5vh, 3rem);
  font-size: clamp(.5rem, .7vw, 2rem);
  background: white;
  color: black;
}
#CANCEL-btn:hover{
  background: black;
  color: white;
}
.alertBtn{
  background: black;
  color: white;
  border: 1px solid black;
  text-align: center;
  display: flex; 
  justify-content: center;
  align-items: center;
  width: clamp(1.5rem, 5.5vw, 5rem);
  height: clamp(1rem, 3.5vh, 3rem);
  font-size: clamp(.5rem, 1vw, 2rem);
}
.alertBtn:hover{
  background: white;
  color: black;
  border: 1px solid black;
  padding: 7px 15px;
  cursor: pointer;
  scale: 1.01;
  transition: .4s all;
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
#tryon-form h1{
  font-size: 20px;
  letter-spacing: 2px;
}
#tryon-form label{
  width: 20%;
  height: 30%;
  left: 50%;
  transform: translateX(-50%);
  border: 2px dashed #ccc;
  position: absolute;
  border-radius: 5px;
  cursor: pointer;
  font-size: clamp(.5rem, 1vw, 1rem);
  color: #555;
  transition: .25s;
  text-align: center;
  top: 30%;
}
#tryon-form label:hover{
  border-color: black;
  color: black;
}
#tryon-form button{
  width: 30%;
  height: 20%;
  left: 50%;
  transform: translateX(-50%);
  position: absolute;
  padding: 12px;
  border: none;
  background: black;
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  font-weight: 600;
  letter-spacing: 1px;
  font-size: clamp(.5rem, 1vw, 1rem);
  cursor: pointer;
  transition: .25s;
  z-index: 1;
  top: 60%;
}
#tryon-form button:hover{
  background:#333;
}
#progress-container{
  display: none;
  border: 1px solid black;
  width: 80vw;
  max-width: 350px;
  height: clamp(1rem, 3vh, 2rem);
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
    </style>
  </head>
  <body>
    <div id="alertNotice">
      <button id="closeAlertBtn">&times;</button>
      <h4></h4>
      <span></span>
  <div id="alert-div">
    <button class="alertBtn" id="OK-btn">OK</button>
    <button class="alertBtn" id="CANCEL-btn">CANCEL</button>
  </div>
  <form style="display: none;" id="tryon-form" action="http://127.0.0.1:5000/api/generate" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="username" value="<?=$_SESSION['username']?>">
    <input type="file" id="try-on-input" name="person" hidden>
    <input type="hidden" name="cloth" id="cloth">
    <label id="fileChoose" for="try-on-input">Choose your file</label>
    <button id="genBtn" type="submit">Generate</button>
    <div id="progress-container">
    <span style="position: absolute;"></span>
    <div id="progress"></div>
  </div>
  </form>
</div>
    <div class="head">
      <div class="banner">
        <div class="banner-left">
          <div class="banner-content">
            <p class="sub-title">Spring / Summer 2026</p>
            <h1>
              Minimalist <br />
              & Timeless
            </h1>
            <p class="description">
              Explore the newest collection and experience minimal style, celebrating pure beauty and delicate craftsmanship with a single needle and thread
            </p>
            <a href="#product-section" class="btn-shop">View Details</a>
          </div>
        </div>
        <div class="banner-right"></div>
      </div>
    </div>
    <div class="body">
      <section class="product-section" id="product-section">
        <div class="product-collection">
          <p class="product-subtitle">Collection</p>
          <h2 class="product-title">High Fashion</h2>
          <div class="line"></div>
          <div class="product-container">
          <?php foreach($product as $p): ?>
            <?php if($p['product_category'] == "collections"): ?>
            <div id="product-<?=$p['id']?>" class="product-card" data-img="../<?=$p['product_img']?>" 
                                      data-name="<?=$p['product_name']?>" 
                                      data-price="<?=$p['product_price']?>"
                                      data-id="<?=$p['id']?>"
                                      data-category="<?=$p['product_category']?>">
              <button class="wishlist-btn">❤</button>

              <div class="image-box">
                <img
                  src="../<?=$p['product_img']?>"
                  alt="Product"
                />
                <div class="image-overlay">
                  <button class="details-btn">View Details</button>
                </div>
              </div>

              <div class="info-box">
                <span class="brand">TRINITY</span>
                <h2 class="title"><?=$p['product_name']?></h2>

                <div class="price-wrapper">
                  <span class="new-price"><?=$p['product_price']?>$</span>
                </div>
              </div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
          </div>
        </div>
        </div>
        <div class="product-header" id="product-header">
          <p class="product-subtitle">Shop Wardrobe</p>
          <h2 class="product-title">ALL</h2>
          <div class="line"></div>
        <div class="product-container">
          <?php foreach($product as $p): ?>
            <?php if($p['product_category'] != "collections"): ?>
            <div id="product-<?=$p['id']?>" class="product-card" data-img="../<?=$p['product_img']?>" 
                                      data-name="<?=$p['product_name']?>" 
                                      data-price="<?=$p['product_price']?>"
                                      data-id="<?=$p['id']?>"
                                      data-category="<?=$p['product_category']?>">
              <button class="wishlist-btn">❤</button>

              <div class="image-box">
                <img
                  src="../<?=$p['product_img']?>"
                  alt="Product"
                />
                <div class="image-overlay">
                  <button class="details-btn">View Details</button>
                </div>
              </div>

              <div class="info-box">
                <span class="brand">TRINITY</span>
                <h2 class="title"><?=$p['product_name']?></h2>

                <div class="price-wrapper">
                  <span class="new-price"><?=$p['product_price']?>$</span>
                </div>
              </div>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
          </div>
        </div>
      </section>
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
                    <input type="hidden" name="username" value="<?=htmlspecialchars($username)?>">    
                    <input type="hidden" name="product_id" id="modal-product-id">
                    <input type="hidden" name="product_name" id="modal-product-name">
                    <input type="hidden" name="product_type" id="modal-product-type">
                    <input type="radio" name="cart_size" value="S" id="S-size-<?=$p['id']?>" hidden checked>
                    <input type="radio" name="cart_size" value="M" id="M-size-<?=$p['id']?>" hidden>
                    <input type="radio" name="cart_size" value="L" id="L-size-<?=$p['id']?>" hidden>
                    <input type="radio" name="cart_size" value="XL" id="XL-size-<?=$p['id']?>" hidden> 
                    <button class="modal-add add-cart-btn-big" type="submit">ADD TO CART</button>
            </form>
      <div id="modal-detail">Details</div>
    </div>
  </div>
</div>  
    </div>
    <section id="menu">
        <div id="text-menu">
            <div id="logo" onclick="window.location.href='../Pages/'">TRINITY</div>
            <div id="text">
                <span onclick="window.location.href='../Pages/'">Home</span>
                <span onclick="window.location.href='#product-section'">Shop</span>
                <span onclick="window.location.href='#product-section'">Collection</span>
                <span onclick="window.location.href='contact.php'">Contact</span>
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
                <path fill="currentColor" d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/>
            </svg>
            <?php if(isset($_SESSION['username'])): ?>
                <p onclick="window.location.href='user.php'"><?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account" onclick="window.location.href='user.php'">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
            <?php else: ?>
                    <input type="submit" value="Login" id="login-input" onclick="window.location.href='log.php'" hidden>
                    <label for="login-input">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 448 512">
                            <path d="M144 128a80 80 0 1 1 160 0 80 80 0 1 1 -160 0zm208 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0zM48 480c0-70.7 57.3-128 128-128l96 0c70.7 0 128 57.3 128 128l0 8c0 13.3 10.7 24 24 24s24-10.7 24-24l0-8c0-97.2-78.8-176-176-176l-96 0C78.8 304 0 382.8 0 480l0 8c0 13.3 10.7 24 24 24s24-10.7 24-24l0-8z"/>
                        </svg>
                    </label>
            <?php endif; ?>
        </div>
<div id="fast-menu">
    <div class="menu-item">
        <div class="menu-title">TRINITY</div>
            <div class="submenu">
                <div class="submenu-item">T-shirt
                    <div class="sub-sub" data-category="men" data-name="Basic T-shirt" onclick="window.location.href='#product-header'">Basic</div>
                    <div class="sub-sub" data-category="men" data-name="Oversize T-shirt" onclick="window.location.href='#product-header'">Oversize</div>
            </div>
            <div class="submenu-item">Polo shirt
                <div class="sub-sub" data-category="men" data-name="Basic Polo" onclick="window.location.href='#product-header'">Basic</div>
                <div class="sub-sub" data-category="men" data-name="Logo Polo" onclick="window.location.href='#product-header'">Logo</div>
            </div>
            <div class="submenu-item">Hoodie
                <div class="sub-sub" data-category="men" data-name="Signature" onclick="window.location.href='#product-header'">Signature</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY LADIES</div>
        <div class="submenu">
            <div class="submenu-item">T-shirt
                <div class="sub-sub" data-category="women" data-name="Basic T-shirt" onclick="window.location.href='#product-header'">Basic</div>
                <div class="sub-sub" data-category="women" data-name="Oversize T-shirt" onclick="window.location.href='#product-header'">Logo</div>
            </div>
            <div class="submenu-item">Blouse
                <div class="sub-sub" data-category="women" data-name="Classic Blouse" onclick="window.location.href='#product-header'">Classic</div>
                <div class="sub-sub" data-category="women" data-name="Wrap Blouse" onclick="window.location.href='#product-header'">Wrap</div>
            </div>
            <div class="submenu-item">Crop top
                <div class="sub-sub" data-category="women" data-name="Basic CropTop" onclick="window.location.href='#product-header'">Basic</div>
                <div class="sub-sub" data-category="women" data-name="Tank CropTop" onclick="window.location.href='#product-header'">Tank</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">GIFT VOUNCHER</div>
        <div class="submenu">
            <div onclick="window.location.href='voucher.php'">Check voucher</div>
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
    <script>
      const isLogin = <?= isset($_SESSION['username']) ? 'true' : 'false' ?>;
      const products = document.querySelectorAll(".product-card");
      const conModal = document.querySelector(".modal-container");
      const modal = document.getElementById("product-modal");
      const modalImg = document.getElementById("modal-img");
      const modalName = document.getElementById("modal-name");
      const modalPrice = document.getElementById("modal-price");
      const closeBtn = document.querySelector(".close-modal");
      const modalProductId = document.getElementById("modal-product-id");
      const modalProductName = document.getElementById("modal-product-name");
      const modalProductType = document.getElementById("modal-product-type");
      const try_on = document.getElementById("Try-on-form");
      const try_on_modal = document.getElementById("try-on-modal");
      const try_on_input = document.getElementById("cloth");
      const addCart = document.querySelectorAll(".add-cart-btn-big");
      const sizeAdd = document.querySelectorAll(".sizes label");
      const alert = document.getElementById("alertNotice");
      const alertName = document.querySelector("#alertNotice h4");
      const alertContent = document.querySelector("#alertNotice span");
      const alertOkBtn = document.getElementById("OK-btn");
      const alertCancelBtn = document.getElementById("CANCEL-btn");
      const formTryOn = document.getElementById("tryon-form");
      const filter = document.querySelectorAll(".sub-sub");
      const params = new URLSearchParams(window.location.search);
      const category = params.get("category");
      const name = params.get("name");

      sizeAdd.forEach(label =>
        label.addEventListener('click', ()=>{
          sizeAdd.forEach(label =>{
            label.style.color = "black";
            label.style.background = "white";
          });
        label.style.color = "white";
        label.style.background = "black";
        })
      )

      const detailBtn = document.getElementById("modal-detail");
      let currentProductId = null;

      products.forEach(product => {
        const viewBtn = product.querySelector(".details-btn");
            viewBtn.addEventListener('click', ()=>{
              modalImg.src = product.dataset.img;
              modalName.textContent = product.dataset.name;
              modalPrice.textContent = product.dataset.price + "$";
              modalProductId.value = product.dataset.id;
              modalProductName.value = product.dataset.name;
              modalProductType.value = "default";
              currentProductId = product.dataset.id;
              try_on_input.value = product.dataset.img;
              modal.style.display = "flex";
            });
      });




      const title = document.querySelector("#product-header .product-title");
      filter.forEach(fil =>{
        fil.addEventListener('click', ()=>{
          const fType = fil.dataset.category;
          const fName = fil.dataset.name;
          title.textContent = fName;
          products.forEach(product =>{
            const pType = product.dataset.category;
            const pName = product.dataset.name;
            const show = pType === "collections" ||
            (pType === fType && pName.includes(fName));
            product.style.display = show ? "" : "none";
          });
        });
      });

      if(category){
        filter.forEach(fil=>{
      if(
        fil.dataset.category === category &&
        fil.dataset.name === name
      ){
        fil.click();
      }
      });
      }


      let timer;
      addCart.forEach(btn =>{
        btn.addEventListener('click', function(e){
          if(!isLogin){
            e.preventDefault();
            clearTimeout(timer);
            alert.classList.add("alert");
            alertName.textContent = "TRINITY";
            alertContent.textContent = "Please login first to use this feature!";
            const okClick = alertOkBtn.addEventListener('click', ()=>{
              window.location.href = "log.php";
            });
            const cancelClick = alertCancelBtn.addEventListener('click', ()=>{
              alert.classList.remove("alert");
            });
            timer = setTimeout(function(){
              alert.classList.remove("alert");
            }, 5000);
          }
        });
      });
      modal.addEventListener('click', function(e){
        if(e.target === modal){
          modal.style.display = "none";
          alert.classList.remove("alert");
          if(alert.classList.contains("tryon")){
            alert.classList.remove("tryon");
            alert.classList.add("tryon-close");
          }
        }
      });

      detailBtn.onclick = function(){
        if(currentProductId){
          window.location.href = "detail.php?id=" + currentProductId;
        }
      };

      closeBtn.addEventListener('click', ()=>{
        modal.style.display = "none";
      });

      try_on.addEventListener('click', (e)=>{
        if(!isLogin){
          e.preventDefault();
          alert.classList.add("alert");
          alertName.textContent = "TRINITY";
          alertContent.textContent = "Please login first to use this feature!";
          const okClick = alertOkBtn.addEventListener('click', ()=>{
            window.location.href = "log.php";
          });
          const cancelClick = alertCancelBtn.addEventListener('click', ()=>{
            alert.classList.remove("alert");
          });
        }else if(isLogin){
            if(!alert.classList.contains("tryon-close") && !alert.classList.contains("tryon")){
              alertName.textContent = "TRINITY VIRTUAL AI TRY ON";
              alertOkBtn.style.display = "none";
              formTryOn.style.display = "flex";
              alert.classList.add("alert");
            }
        }
      });

      const closeAlert = document.getElementById("closeAlertBtn");

      closeAlert.addEventListener('click', ()=>{
        alert.classList.remove("tryon");
        alert.classList.add("tryon-close");
      });

      alert.addEventListener('click', function(e){
        if(alert.classList.contains("tryon-close") && e.target != closeAlert){
            alert.classList.add("tryon");
            alert.classList.remove("tryon-close");
        }
      });
      

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


      const form = document.querySelector("#tryon-form");
        form.addEventListener("submit", async function(e){
          e.preventDefault();
          document.getElementById("progress-container").style.display = "flex";
          document.getElementById("fileChoose").style.display = "none";
          document.getElementById("genBtn").style.display = "none";
          document.getElementById("alertNotice").classList.remove("alert");
          document.getElementById("alertNotice").classList.add("tryon");
          const formData = new FormData(this);
          const res = await fetch("http://127.0.0.1:5000/api/generate",{
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

      const username = <?php echo json_encode($username); ?>;
      let abc = 0;
      let animationInterval = null;

      setInterval(async () =>{
        const res = await fetch(`http://localhost:5000/api/progress/${username}`);
        const data = await res.json();
        if(data.progress < 2){
          document.querySelector("#progress-container span").classList.add("animation");
        if(!animationInterval){
          animationInterval = setInterval(() =>{
            abc++;
            if(abc == 1){
              document.getElementById("animate").style.opacity = "1";
              document.getElementById("animate").classList.add("animated");
            }else if(abc > 12){
              document.getElementById("animate").style.opacity = "0";
              document.getElementById("animate").classList.remove("animated");
              abc = 0;
            } 
          }, 1000);
        }
        } 
        else if(data.progress > 2){
          let percent = data.progress + data.progress / 4.75; 
          if(alert.classList.contains("tryon-close")){
            alert.querySelector("h4").style.opacity = "1";
            alert.querySelector("h4").style.visibility = "visible";
            alert.querySelector("h4").textContent = `${parseFloat(percent.toFixed(2))}%`;
          }
          document.getElementById("progress").style.width = `${percent}%`;
          document.querySelector("#progress-container span").classList.remove("animation");
          document.getElementById("animate").classList.remove("animated");
          document.getElementById("animate").style.display = "none";
        if(animationInterval){
          clearInterval(animationInterval);
          animationInterval = null;
        }
        }
      }, 10000);
    </script>
  </body>
</html>

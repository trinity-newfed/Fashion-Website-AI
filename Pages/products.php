<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();

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
      #menu {
        width: 100vw;
        max-width: 1500px;
        height: 70px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
      }
      #text-menu {
        width: 70%;
        height: 100%;
        display: flex;
        justify-content: start;
        align-items: center;
        position: relative;
        left: 0;
        color: rgb(255, 147, 64);
      }
      #logo {
        position: relative;
        left: 0;
        width: 10%;
        height: 100%;
        display: grid;
        place-items: center;
        font-weight: bold;
        color: rgb(255, 255, 255);
        font-size: clamp(1rem, 2vw, 2.5rem);
        cursor: default;
      }
      #text {
        width: 60%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bolder;
      }
      #text span:hover {
        transition: 0.3s all;
        cursor: pointer;
        background-color: rgb(0, 0, 0);
        color: white;
      }

      #utility-menu {
        width: 20%;
        height: 100%;
        display: flex;
        justify-content: space-around;
        align-items: center;
      }
      .icon {
        width: 1.2rem;
        height: 1.2rem;
      }
      .icon path {
        scale: 1;
      }
      #login-btn {
        width: 30%;
        height: 40%;
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
      #login-btn:hover {
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
        height: 500px;
        position: relative;
        display: grid;
        justify-content: center;
        align-items: center;
        margin: auto;
        grid-template-columns: 250px 250px 250px 250px;
        gap: 20px;
        scroll-behavior: smooth;
      }
      .type_clothing div {
        width: 250px;
        height: 400px;
        background-color: #ffffcc;
        border-radius: 20px;
        justify-content: center;
        align-items: center;
        line-height: 1;
        transition: all 0.4s;
        cursor: pointer;
      }
      .type_clothing svg {
        width: 100px;
        height: 110px;
        display: block;
        margin: 50px auto 0;
        opacity: 0.8;
      }
      .type_clothing p {
        font-family: "Poppins", sans-serif;
        font-size: 15px;
        letter-spacing: 0.5px;
        line-height: 1.6;
        color: #333;
        width: 80%;
        margin: 20px auto 0;
        text-align: center;
        cursor: pointer;
      }
      .type_clothing div:hover {
        cursor: pointer;
        transition: all 0.4s;
        transform: translateY(-10px);
      }
      #body {
        width: 100vw;
        max-width: 1500px;
        height: 100svh;
        max-height: 900px;
        position: relative;
        display: flex;
        justify-content: center;
        margin: 0 auto;
        overflow: auto;
      }
      .men-fashion {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        margin: 0;
        gap: 20px;
      }
      .men-fashion-product {
        width: 300px;
        height: 500px;
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
        height: 300px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
      }
      .product-price {
        border: 1px solid black;
        width: 100px;
        height: 40px;
        border-radius: 10px;
        background-color: #1c1c1c;
        color: white;
        font-family: "Inter", sans-serif;
        font-weight: bolder;
        font-size: 17px;
        position: relative;
        margin: 10px 10px;
        line-height: 1.6;
        text-align: center;
        user-select: none;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .product-brand {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #b5835a;
        margin-bottom: 5px;
        font-weight: 700;
      }
      .product-name {
        font-family: "Montserrat", serif;
        font-weight: bold;
        font-size: 20px;
        position: relative;
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
        position: absolute;
        text-align: center;
        justify-content: center;
        align-items: center;
        min-height: 30px;
        min-width: 30px;
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
      .line {
        width: 40px;
        height: 1px;
        background-color: white;
        transform: rotate(90deg);
        position: absolute;
        margin-left: 40px;
        margin-top: 25px;
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
        grid-template-columns: repeat(4, 1fr);
        margin: 0;
        gap: 20px;
        margin-top: 10%;
      }
      .unisex-fashion {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        margin: 0;
        gap: 20px;
        margin-top: 10%;
      }
      .accessory-fashion {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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

.sizes span {
  width: 40px;
  height: 40px;
  border: 1px solid black;
  display: grid;
  place-items: center;
  cursor: pointer;
  transition: 0.3s;
}

.sizes span:hover,
.sizes span.active {
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
        <div id="utility-menu">
          <svg class="icon" viewBox="0 0 640 512" aria-hidden="true" onclick="window.location.href='cart.php'">
            <path
              fill="currentColor"
              d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"
            />
          </svg>
          <?php if(isset($_SESSION['username'])): ?>
                <p><?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div id="login-btn">
                    <form action="../Database/createdatabase.php" method="post" style="width: 100%; height: 100%;">
                        <input type="submit" value="Login" style="width: 100%; height: 100%; background-color: transparent; border: none; color: white;">
                    </form>
                
                </div>
            <?php endif; ?>
        </div>
      </section>
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
    <!--BODY-->

    <section id="body"> 
      <section id="body-products">
        <p class="introduct">
        <span>&ndash;&ndash;&ndash;Newest Collection&ndash;&ndash;&ndash;</span>
    </p>
        <section class="men-fashion" id="newest">
          <?php if(empty($product)): ?>
            Nothing in this field
          <?php else: ?>
            <?php foreach($product as $p): ?>
          <div class="men-fashion-product"  data-id="<?= $p['id'] ?>"
                                            data-name="<?= htmlspecialchars($p['product_name']) ?>"
                                            data-price="<?= htmlspecialchars($p['product_price']) ?>"
                                            data-img="../picture-uploads/<?= htmlspecialchars($p['product_img']) ?>">
            <div class="product-image" style="background-image: url(../picture-uploads/<?=$p['product_img']?>);"></div>
            <div class="product-price"><?=$p['product_price']?>$</div>
            <div class="product-brand">Trinity</div>
            <div class="product-name"><?=$p['product_name']?></div>
            <div class="box">
              <div class="product-cart">
                <svg class="icon" viewBox="0 0 640 512" aria-hidden="true">
                  <path
                    fill="currentColor"
                    d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"
                  />
                </svg>
              </div>
            </div>
            <div class="product-try"></div>
          </div>
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
          <div class="men-fashion-product"  data-id="<?= $p['id'] ?>"
                                            data-name="<?= htmlspecialchars($p['product_name']) ?>"
                                            data-price="<?= htmlspecialchars($p['product_price']) ?>"
                                            data-img="../picture-uploads/<?= htmlspecialchars($p['product_img']) ?>">
            <div class="product-image" style="background-image: url(../picture-uploads/<?=$p['product_img']?>);"></div>
            <div class="product-price"><?=$p['product_price']?>$</div>
            <div class="product-brand">Trinity</div>
            <div class="product-name"><?=$p['product_name']?></div>
            <div class="box">
              <div class="product-cart">
                <svg class="icon" viewBox="0 0 640 512" aria-hidden="true">
                  <path
                    fill="currentColor"
                    d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"
                  />
                </svg>
              </div>
            </div>
            <div class="product-try"></div>
          </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>
        <p class="introduct">
        <span>&ndash;&ndash;&ndash;Woman Fashion&ndash;&ndash;&ndash;</span>
      </p>
        <section class="unisex-fashion">
          <?php if(empty($product)): ?>
            Nothing in this field
          <?php else: ?>
            <?php foreach($product as $p): ?>
          <div class="men-fashion-product" data-id="<?= $p['id'] ?>"
                                           data-name="<?= htmlspecialchars($p['product_name']) ?>"
                                           data-price="<?= htmlspecialchars($p['product_price']) ?>"
                                           data-img="../picture-uploads/<?= htmlspecialchars($p['product_img']) ?>">
            <div class="product-image" style="background-image: url(../picture-uploads/<?=$p['product_img']?>);"></div>
            <div class="product-price"><?=$p['product_price']?>$</div>
            <div class="product-brand">Trinity</div>
            <div class="product-name"><?=$p['product_name']?></div>
            <div class="box">
              <div class="product-cart">
                <svg class="icon" viewBox="0 0 640 512" aria-hidden="true">
                  <path
                    fill="currentColor"
                    d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"
                  />
                </svg>
              </div>
            </div>
            <div class="product-try"></div>
          </div>
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
          <div class="men-fashion-product"  data-id="<?= $p['id'] ?>"
                                            data-name="<?= htmlspecialchars($p['product_name']) ?>"
                                            data-price="<?= htmlspecialchars($p['product_price']) ?>"
                                            data-img="../picture-uploads/<?= htmlspecialchars($p['product_img']) ?>">>
            <div class="product-image" style="background-image: url(../picture-uploads/<?=$p['product_img']?>);"></div>
            <div class="product-price"><?=$p['product_price']?>$</div>
            <div class="product-brand">Trinity</div>
            <div class="product-name"><?=$p['product_name']?></div>
            <div class="box">
              <div class="product-cart">
                <svg class="icon" viewBox="0 0 640 512" aria-hidden="true">
                  <path
                    fill="currentColor"
                    d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"
                  />
                </svg>
              </div>
            </div>
            <div class="product-try"></div>
          </div>
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
          <span>S</span>
          <span>M</span>
          <span>L</span>
          <span>XL</span>
        </div>
      </div>

      <button class="modal-add">ADD TO CART</button>
      <div id="modal-detail">Details</div>
    </div>

  </div>
</div>

<script>
const products = document.querySelectorAll(".men-fashion-product");
const modal = document.getElementById("product-modal");
const modalImg = document.getElementById("modal-img");
const modalName = document.getElementById("modal-name");
const modalPrice = document.getElementById("modal-price");
const closeBtn = document.querySelector(".close-modal");

products.forEach(product => {
  product.addEventListener("click", function(e) {

    if(e.target.closest(".product-cart")) return;

    modalImg.src = this.dataset.img;
    modalName.textContent = this.dataset.name;
    modalPrice.textContent = this.dataset.price + "$";

    modal.style.display = "flex";
  });
});

closeBtn.onclick = () => modal.style.display = "none";

window.onclick = (e) => {
  if(e.target === modal){
    modal.style.display = "none";
  }
};


const detailBtn = document.getElementById("modal-detail");
let currentProductId = null;

products.forEach(product => {
  product.addEventListener("click", function(e) {

    if(e.target.closest(".product-cart")) return;

    modalImg.src = this.dataset.img;
    modalName.textContent = this.dataset.name;
    modalPrice.textContent = this.dataset.price + "$";

    currentProductId = this.dataset.id;

    modal.style.display = "flex";
  });
});

detailBtn.onclick = function() {
  if(currentProductId){
    window.location.href = "detail.php?id=" + currentProductId;
  }
};

window.addEventListener("load", function () {
    if (window.location.hash) {

        const element = document.querySelector(window.location.hash);
        if (element) {
            element.scrollIntoView({ behavior: "smooth" });
        }
        history.replaceState(null, null, window.location.pathname);
    }
});
</script>

  </body>
</html>

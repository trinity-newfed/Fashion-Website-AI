<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
session_start();

$username = $_SESSION['username'];

$sql = "SELECT * FROM userdata
        WHERE username = ?";
$stmt = $conn->prepare($sql);
if(!$stmt){
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$img = "SELECT * FROM tryon WHERE username = ?";
$stmt = $conn->prepare($img);
$stmt->bind_param("s", $username);
$stmt->execute();

$fetchData = $stmt->get_result();
$stmt->close();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Page</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
  </head>
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
      width: 100vw;
      scroll-behavior: smooth;
      overflow-x: hidden;
      max-width: 1500px;
      max-height: 900px;
    }
    /*section head - menu*/
    #head {
      position: relative;
      margin: auto;
      width: 100vw;
      max-width: 1500px;
      max-height: 900px;
      top: 0;
    }
/*START MENU*/
#menu{
    width:100%;
    max-width: 1500px;
    height:70px;
    position:fixed;
    top:0;
    left:50%;
    transform:translateX(-50%);
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 60px;
    background:rgba(255,255,255,0.6);
    backdrop-filter:blur(10px);
    z-index:1000;
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
    .body {
      display: flex;
      position: relative;
      margin: 0;
      max-height: 900px;
      justify-content: right;
      align-items: right;
    }
    .user-box {
      width: 100vw;
      height: 100vh;
      max-width: 1500px;
      max-height: 900px;
      border: 1px solid black;
      position: relative;
      padding-top: 5%;
      margin: auto;
      display: flex;
      flex-direction: row;
    }
    .user-information {
      width: 20vw;
      height: 100vh;
      max-width: 1000px;
      max-height: 900px;
      background-color: black;
      color: white;
      display: flex;
      align-items: center;
      flex-direction: column;
    }
    .user-avatar {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      background-color: white;
      background-image: url(../Pictures/Collections/avatar-user-test.jpg);
      background-position: center;
      background-size: cover;
      object-fit: cover;
      outline: 3px solid #ff4500;
      outline-offset: 10px;
      margin-top: 50px;
      transition: 0.4s;
    }
    .user-avatar:hover {
      transition: 0.4s;
      scale: 1.1;
      cursor: pointer;
    }
    .user-name {
      position: relative;
      text-align: center;
      font-family: "Yanone Kaffeesatz", sans-serif;
      font-style: normal;
      font-size: 23px;
      color: white;
      display: flex;
      margin-top: 40px;
      letter-spacing: 3px;
    }
    .user-tier {
      font-size: 15px;
      letter-spacing: 3px;
      margin-top: 20px;
      color: #ff4500;
    }
    .line1 {
      color: #ffffff;
      position: relative;
      opacity: 0.2;
      margin-top: 10%;
    }
    .user-sex {
      margin-top: 10px;
      opacity: 0.4;
      display: flex;
      position: relative;
      justify-content: space-between;
    }
    .user-details {
      width: 80%;
      margin-top: 20px;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
      font-family: "Segoe UI", sans-serif;
      font-size: 12px;
    }

    .info-row span:first-child {
      color: #888;
    }

    .info-row span:last-child {
      color: white;
      font-weight: 500;
    }
    .user-setting {
      width: 80%;
      height: 30px;
      background-color: rgb(0, 0, 0);
      border: 1px solid white;
      margin-top: 20%;
      text-align: center;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 16px;
      font-family: Arial;
      cursor: pointer;
      transition: 0.4s;
    }
    .user-setting:hover {
      transition: 0.4s;
      background-color: rgb(255, 255, 255);
      border: 1px solid rgb(0, 0, 0);
      color: black;
    }
    .user-cart {
      position: relative;
      max-width: 1500px;
      width: 80vw;
      height: 100vh;
      max-height: 900px;
      right: 0;
      background-color: rgb(255, 255, 255);
      overflow: auto;
    }
    .user-cart p:nth-child(1) {
      color: black;
      font-family: "Segoe UI", Helvetica, Arial, sans-serif;
      font-weight: 700;
      font-size: 30px;
      padding: 0 15px;
    }
    .user-cart-alert {
      color: black;
      font-family: "Segoe UI", Helvetica, Arial, sans-serif;
      font-size: 17px;
      margin: 10px 10px;
    }
    .line2 {
      width: 60px;
      height: 4px;
      background-color: #ff4500;
      position: absolute;
      margin: -20px 15px;
    }
    #try-on-container{
      max-width: 1000px;
      display: grid;
      place-items: center;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 30px;
    }
    .line3{
      width: 200px;
      height: 300px;
      box-shadow: 3px 3px 13px rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      display: grid;
      place-items: center;
      transition: .1s all;
    }
    .line3:hover{
      scale: 1.05;
      transition: .3s all;
    }
    .line3 img{
      width: 90%;
      height: 90%;
      max-width: 180px;
      max-height: 180px;
      object-fit: cover;
      border-radius: 10px;
    }
    .line3 form{
      width: 40%;
      height: 50%;
    }
    .line3 button{
      background: black;
      color: white;
      width: 100%;
      height: 100%;
      border-radius: 15px;
      border: 1px solid black;
      cursor: pointer;
    }
    .add-more {
      width: 200px;
      height: 250px;
      outline: 5px solid gray;
      position: relative;
      display: flex;
      margin: 20px 20px;
      justify-content: center;
      align-items: center;
      text-align: center;
      font-family: monospace;
      font-size: 20px;
      cursor: pointer;
      transition: 0.4s;
    }
    .add-more:hover {
      transition: 0.4s;
      scale: 1.05;
    }
    .user-history {
      position: relative;
      width: 80vw;
      margin-top: 50%;
    }
    .user-history-AI {
      position: relative;
      width: 80vw;
      margin-top: 50%;
      margin-bottom: 10%;
    }
    .user-history-text {
      color: black;
      font-family: "Segoe UI", Helvetica, Arial, sans-serif;
      font-weight: 700;
      font-size: 30px;
    }
  </style>
  <body>
    <section id="head">
<section id="menu">
        <div id="text-menu">
            <div id="logo" onclick="window.location.href='../Pages/'">TRINITY</div>
            <div id="text">
                <span onclick="window.location.href='../Pages/'">Home</span>
                <span onclick="window.location.href='products.php?#product-section'">Shop</span>
                <span onclick="window.location.href='products.php?#product-section'">Collection</span>
                <span>Contact</span>
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
                    <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Basic T-shirt'">Basic</div>
                    <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Oversize T-shirt'">Oversize</div>
            </div>
            <div class="submenu-item">Polo shirt
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Basic Polo'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Logo Polo'">Logo</div>
            </div>
            <div class="submenu-item">Hoodie
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Hoodie'">Signature</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY LADIES</div>
        <div class="submenu">
            <div class="submenu-item">T-shirt
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Basic T-shirt'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Oversize T-shirt'">Oversize</div>
            </div>
            <div class="submenu-item">Blouse
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Classic Blouse'">Classic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Wrap Blouse'">Warp</div>
            </div>
            <div class="submenu-item">Crop top
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Basic CropTop'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Tank CropTop'">Tank</div>
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
    </section>
    <section class="body">
      <div class="user-box">
        <div class="user-information">
          <?php if(isset($_SESSION['username'])): ?>
          <div class="user-avatar">
            <img style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="">
          </div>
          <div class="user-name"><?=$_SESSION['username']?></div>
          <div class="user-tier"><?=$user['user_tier']?></div>
          <div class="line1">_________________________</div>
          <div class="user-details">
            <div class="info-row">
              <span>Sex:</span>
              <span><?=$user['user_sex']?></span>
            </div>
            <div class="info-row">
              <span>Hotline:</span>
              <span><?=$user['user_hotline']?></span>
            </div>
            <div class="info-row">
              <span>Email:</span>
              <span><?=$user['email']?></span>
            </div>
            <div class="info-row">
              <span>Address: </span>
              <span><?=$user['user_address']?></span>
            </div>
          </div>
          <div class="user-setting">Edit informations</div>
          <div class="user-setting">
            <form action="logout.php">
              <input type="submit" id="log-out" hidden>
              <label for="log-out">Log out</label>
            </form>
          </div>
          <?php endif; ?>
        </div>
        <div class="user-cart">
          <p>Order state</p>
          <div class="line2"></div>
          <!--<div class="add-more" onclick="window.location.href='https://cosplaytele.com';">Thêm mới <br> + </div>-->
          <p class="user-cart-alert">Nothing here...</p>
          <div class="user-history">
            <p class="user-history-text">Purchase history</p>
            <div class="line2"></div>
            <p class="user-cart-alert">Nothing here...</p>
          </div>
          <div class="user-history-AI">
            <p class="user-history-text">Try on history</p>
            <div id="try-on-container">
              <?php while($row = $fetchData->fetch_assoc()): ?>
              <div class="line3">
                <img src="../AI/static/outputs/user_<?=$_SESSION['username']?>/<?=$row['result_img']?>" alt="">
                <?=$row['created_at']?>
                <form action="../Database/detele_user_tryon.php" method="POST">
                  <input type="text" name="id" value="<?=$row['id']?>" hidden>
                  <button type="submit">Delete</button>
                </form>
              </div>
            <?php endwhile; ?>
            </div>
            <p class="user-cart-alert"></p>
          </div>
        </div>
      </div>
    </section>
    <script>
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
    </script>
  </body>
</html>

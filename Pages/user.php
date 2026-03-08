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
    <title>User</title>
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
      color: rgb(0, 0, 0);
    }
    #logo {
      position: relative;
      left: 0;
      width: 10%;
      height: 100%;
      display: grid;
      place-items: center;
      font-weight: bold;
      color: rgb(255, 147, 64);
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
    #user-account {
      width: clamp(0.25rem, 3vw, 2.5rem);
      height: clamp(0.25rem, 3vw, 2.5rem);
      z-index: 2;
      background-color: #111;
      border-radius: 50%;
    }
    #user-avatar {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
      object-position: center 30%;
    }
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
      margin: 10% auto;
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
      font-style: italic;
      font-size: 16px;
      font-family: monospace;
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
      border: 1px solid black;
      box-shadow: 3px 3px 3px solid rgba(0, 0, 0, 0.7);
      border-radius: 10px;
      display: grid;
      place-items: center;
      transition: .3s all;
    }
    .line3:hover{
      width: 220px;
      transition: .3s all;
    }
    .line3 img{
      width: 90%;
      height: 90%;
      object-fit: cover;
      border-radius: 10px;
    }
    .line3 img:hover{
      filter: brightness(80%);
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
          <div id="logo" onclick="window.location.href = '../Pages/'">T</div>
          <div id="text">
            <span>New Arrival</span>
            <span>Tops</span>
            <span>Bottoms</span>
            <span>Accesorires</span>
            <span>About</span>
          </div>
        </div>
        <div id="utility-menu">
          <svg
            class="icon"
            viewBox="0 0 640 512"
            aria-hidden="true"
            onclick="window.location.href = 'cart.php'"
          >
            <path
              fill="currentColor"
              d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"
            />
          </svg>
          <?php if(isset($_SESSION['username'])): ?>
                <p><?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account" onclick="window.location.href='user.php'">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div id="login-btn">
                    <input type="submit" value="Login" style="width: 100%; height: 100%; background-color: transparent; border: none; color: white;" onclick="window.location.href='log.php'">
                </div>
            <?php endif; ?>
        </div>
      </section>
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
  </body>
</html>

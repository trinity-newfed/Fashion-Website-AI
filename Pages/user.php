<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
session_start();
if(!isset($_SESSION['username'])){
  header("Location: log.php");
  exit();
}
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
    <link rel="stylesheet" href="../Css/user.css">
    <title>User Page</title>
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
  </head>
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
    <section id="footer-2">
            <div class="footer-info" id="fi-1">
                <h2>POLICY</h2>
                <p>Term of delivery</p>
                <p>Term of return</p>
                <p>Purchase policy</p>
            </div>

            <div class="footer-info" id="fi-2">
                <h2>ABOUT US</h2>
                <p>Trinity</p>
                <p>Leadership Team</p>
            </div>

            <div class="footer-info" id="fi-3">
                <h2>GET LATEST DEALS AND MORE</h2>
                <span>Email: triple3tbusiness@gmail.com</span>
                <span>Hotline: 0909.xxx.xxx</span>
                <input placeholder="Contact us...">
            </div>


            <div class="footer-info" id="fi-4">
                <h2>SUPPORT</h2>
                <span>Direct chat</span>
                <span>Hotline: 0808.xxx.xxx</span>
                <div style="display: grid; place-items: center;">
                    <h2>Follow up</h2>
                    <input placeholder="Enter your email...">
                </div>
            </div>

            <div class="footer-info" id="fi-5" style="position: absolute; bottom: 5%; width: 100%; height: 10%; border-top: 1px solid gray;">
                <h1>CONTACT US</h1>
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

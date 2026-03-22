<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
session_start();
if(!isset($_SESSION['username'])){
  header("Location: reglog.php");
  exit();
}
$username = $_SESSION['username'];

$sql = "SELECT * FROM userdata
        WHERE email = ?";
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
$tryonData = $fetchData->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$sql = "SELECT 
        orders.id,
        orders.order_state,
        orders.order_name,
        orders.order_original_price,
        orders.order_final_price,
        order_items.product_name,
        order_items.img,    
        order_items.quantity
        FROM orders
        JOIN order_items ON orders.id = order_items.order_id
        WHERE orders.username = ?
        ORDER BY orders.id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$groupedOrders = [];

foreach ($data as $d) {
    $groupedOrders[$d['id']][] = $d;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Css/user.css">
    <title>Trinity Style - User</title>
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
                <p onclick="window.location.href='user.php'" id="menu-Username" style="cursor: pointer;"><?=$_SESSION['username']?></p>
            <?php else: ?>
                    <input type="submit" value="Login" id="login-input" onclick="window.location.href='reglog.php'" hidden>
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
                    <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Basic T-shirt#product-header'">Basic</div>
                    <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Oversize T-shirt#product-header'">Oversize</div>
            </div>
            <div class="submenu-item">Polo shirt
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Basic Polo#product-header'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Logo Polo#product-header'">Logo</div>
            </div>
            <div class="submenu-item">Hoodie
                <div class="sub-sub" onclick="window.location.href='products.php?category=men&name=Hoodie#product-header'">Signature</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY LADIES</div>
        <div class="submenu">
            <div class="submenu-item">T-shirt
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Basic T-shirt#product-header'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Oversize T-shirt#product-header'">Oversize</div>
            </div>
            <div class="submenu-item">Blouse
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Classic Blouse#product-header'">Classic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Wrap Blouse#product-header'">Warp</div>
            </div>
            <div class="submenu-item">Crop top
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Basic CropTop#product-header'">Basic</div>
                <div class="sub-sub" onclick="window.location.href='products.php?category=women&name=Tank CropTop#product-header'">Tank</div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">GIFT VOUNCHER</div>
        <div class="submenu">
            <div onclick="window.location.href='voucher.php'" style="cursor: pointer;">Check voucher</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY TIER</div>
        <div class="submenu">
            <div onclick="window.location.href='userTier.php'" style="cursor: pointer;">Check your shopping tier</div>
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
            <?php if(empty($user['img'])): ?>
                <img src="../Pictures/Banners/BA.webp" alt="">
            <?php else: ?>
              <img style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" src="../upload/<?=htmlspecialchars($_SESSION['img'])?>" alt="">
            <?php endif; ?>
          </div>
          <div class="user-name"><?=$_SESSION['username']?></div>
          <?php if(empty($user)): ?>
            <div class="user-tier"></div>
          <?php else: ?>
            <?php if($user['user_tier'] == "1"): ?>
                <div class="user-tier" style="color: white;">New Member</div>
            <?php elseif($user['user_tier'] == "2"): ?>
                <div class="user-tier" style="color: silver; background: #2d3036;">Silver</div>
            <?php elseif($user['user_tier'] == "3"): ?>
                <div class="user-tier" style="color: gold; background: #504420;">Gold</div>
            <?php elseif($user['user_tier'] == "4"): ?>
                <div class="user-tier" style="color: lightblue; background: #202e50;">Diamond</div>
            <?php endif; ?>
          <?php endif; ?>
          <div class="line1">_________________________</div>
          <div class="user-details">
            <div class="info-row">
              <span>Sex:</span>
              <?php if(empty($user)): ?>
              <span></span>
              <?php else: ?>
              <span><?=$user['user_sex']?></span>
              <?php endif; ?>
            </div>
            <div class="info-row">
              <span>Hotline:</span>
              <?php if(empty($user)): ?>
              <span></span>
              <?php else: ?>
              <span><?=$user['user_hotline']?></span>
              <?php endif; ?>
            </div>
            <div class="info-row">
              <span>Email:</span>
              <?php if(empty($user)): ?>
              <span></span>
              <?php else: ?>
              <span><?=$user['email']?></span>
              <?php endif; ?>
            </div>
            <div class="info-row">
              <span>Address: </span>
              <?php if(empty($user)): ?>
              <span></span>
              <?php else: ?>
              <span><?=$user['user_address']?></span>
              <?php endif; ?>
            </div>
          </div>
          <div class="user-setting">Edit informations</div>
          <div class="user-setting" onclick="window.location.href='logout.php'">
            Log out
          </div>
          <?php endif; ?>
        </div>
        <div class="user-cart">
          <div style="display: flex; justify-content: space-between; align-items: center; width: 78%; padding-top: 3%;">
            <p>Your Orders</p>
            <select id="order-state-option">
                <option value="Success">Success</option>
                <option value="Delivery">Delivery</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancel">Cancel</option>
                <option value="All">All</option>
            </select>
          </div>
          <div class="line2"></div>
          <div id="order-history">
            <?php if(!empty($groupedOrders)): ?>
                <?php foreach($groupedOrders as $order_id => $items): ?>
                    <div class="order-block">
                        <div class="order-state" style="width: 100%; display: flex; justify-content: space-around; align-items: center;">
                            <h3 class="order-name">#<?= $items[0]['order_name'] ?></h3>
                            <?php if($items[0]['order_state'] == "success"): ?>
                                <span class="state" style="color: #16a34a; background: #e6f9ed;"><?=$items[0]['order_state']?></span>
                            <?php elseif($items[0]['order_state'] == "cancel"): ?>
                                <span class="state" style="color: #dc2626; background: #ffeaea;"><?=$items[0]['order_state']?></span>
                            <?php elseif($items[0]['order_state'] == "delivery"): ?>
                                <span class="state" style="color: #f59e0b; background: #fff4e5;"><?=$items[0]['order_state']?></span>
                            <?php elseif($items[0]['order_state'] == "delivered"): ?>
                                <span class="state" style="color: #6b7280c7; background: #f3f4f6;"><?=$items[0]['order_state']?></span>
                            <?php endif; ?>
                        </div>
                        <div class="order-img">
                            <img src="../<?= $items[0]['img'] ?>" alt="">
                            <div class="order-img-info">
                                <h3><?=$items[0]['product_name']?></h3>
                                <span style="text-align: end; color: gray; text-decoration-line: line-through; font-size: clamp(.7rem, .8vw, 1.1rem);"><?=$items[0]['order_original_price']?>$</span>
                                <span style="font-size: clamp(.9rem, 1vw, 1.2rem);">Order totals (<?= count($items) ?> items): <?=$items[0]['order_final_price']?>$</span>
                            </div>
                        </div>
                        <div class="order-info">
                            <button class="re-order">Re-Buy</button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <h3 class="h3-alert">Nothing here...</h3>
                <?php endif; ?>
          </div>
          <p class="user-cart-alert"></p>
          <div class="user-history-AI">
            <p class="user-history-text">Try on history</p>
            <div class="line2"></div>
            <div id="try-on-container">
            <?php if(!empty($tryonData)): ?>
            <?php foreach($tryonData as $to): ?>
              <div class="line3">
                <img src="../AI/static/outputs/user_<?=$_SESSION['username']?>/<?=$to['result_img']?>" alt="">
                <?=$to['created_at']?>
                <form action="../Database/detele_user_tryon.php" method="POST">
                  <input type="text" name="id" value="<?=$to['id']?>" hidden>
                  <button type="submit">Delete</button>
                </form>
              </div>
            <?php endforeach; ?>
            <?php else: ?>
                <h3 class="h3-alert">Nothing here...</h3>
            <?php endif; ?>
            </div>
            <p class="user-cart-alert"></p>
          </div>
        </div>
      </div>
    </section>
<footer class="footer-2">
  <div class="footer-container">
    <div class="footer-left">
      <p class="footer-label">CONTACT US</p>
      <h2 class="footer-title">
        Let’s Discuss Your <br> Style. With Us
      </h2>
      <button class="footer-btn">
        Schedule a call now →
      </button>
      <p class="footer-email-label">OR EMAIL US AT</p>
      <div class="footer-email">
        triple3tbusiness@gmail.com
        <span>📋</span>
      </div>
    </div>

    <div class="footer-right">
      <div class="footer-col">
        <p class="footer-col-title">QUICK LINKS</p>
        <a href="#">Home</a>
        <a href="#">Case Studies</a>
        <a href="#">Gallery</a>
        <a href="#">Blogs</a>
        <a href="#">About Us</a>
      </div>
      <div class="footer-col">
        <p class="footer-col-title">INFORMATION</p>
        <a href="#">Terms of Service</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Cookies Settings</a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>Copyright (c) 2026 trinity-newfed</p>

    <div class="footer-social">
      <span>f</span>
      <span>t</span>
      <span>ig</span>
      <span>in</span>
    </div>
  </div>
</footer>

    <script>
      const email = <?= isset($_SESSION['username']) ? json_encode($_SESSION['username']) : '""' ?>;
      let username1 = email.replace("@gmail.com", "");
      const userWelcome = document.getElementById("menu-Username");
      const menuTitles = document.querySelectorAll(".menu-title");

      const select = document.getElementById("order-state-option");
      select.addEventListener("change", function (){
      const state = this.value.toLowerCase();
      const orderBlocks = document.querySelectorAll(".order-block");
      orderBlocks.forEach(block =>{
        const blockState = block.querySelector(".state").textContent.toLowerCase();
        if(blockState.includes(state) || state == "all"){
            block.style.display = "";
        }else{
            block.style.display = "none";
        }
    });
});
        
        const Blocks = document.querySelectorAll(".order-block");
        Blocks.forEach(blocks =>{
            const blockStates = blocks.querySelector(".state").textContent.toLowerCase();
            if(blockStates == "success"){
                blocks.style.display = "";
            }else{
                blocks.style.display = "none";
            }
        })


      if(userWelcome){
            userWelcome.textContent = "Hi, " + username1;
        }
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

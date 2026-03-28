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
        order_items.order_id,
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
    $totalItems = 0;
    $totalItems += $d['quantity'];
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
            <svg class="icon" id="edit" style="position: absolute; right: 15%; top: 2%;" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M256.1 248a120 120 0 1 0 0-240 120 120 0 1 0 0 240zm-29.7 56c-98.5 0-178.3 79.8-178.3 178.3 0 16.4 13.3 29.7 29.7 29.7l196.5 0 10.9-54.5c4.3-21.7 15-41.6 30.6-57.2l67.3-67.3c-28-18.3-61.4-28.9-97.4-28.9l-59.4 0zM332.3 466.9l-11.9 59.6c-.2 .9-.3 1.9-.3 2.9 0 8 6.5 14.6 14.6 14.6 1 0 1.9-.1 2.9-.3l59.6-11.9c12.4-2.5 23.8-8.6 32.7-17.5l118.9-118.9-80-80-118.9 118.9c-8.9 8.9-15 20.3-17.5 32.7zm267.8-123c22.1-22.1 22.1-57.9 0-80s-57.9-22.1-80 0l-28.8 28.8 80 80 28.8-28.8z"/></svg>
          <?php if(isset($_SESSION['username'])): ?>
          <div class="user-avatar">
            <?php if(empty($user['img'])): ?>
                <img src="../Pictures/Banners/BA.webp" alt="">
            <?php else: ?>
              <img style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" src="../<?=htmlspecialchars($user['img'])?>" alt="">
            <?php endif; ?>
          </div>
          <div class="user-name"><?=$_SESSION['username']?></div>
          <?php if(empty($user)): ?>
            <div class="user-tier" onclick="window.location.href='userTier.php'"></div>
          <?php else: ?>
            <?php if($user['user_tier'] == "1"): ?>
                <div class="user-tier" style="color: white;" onclick="window.location.href='userTier.php'">New Member</div>
            <?php elseif($user['user_tier'] == "2"): ?>
                <div class="user-tier" style="color: silver; background: #2d3036;" onclick="window.location.href='userTier.php'">Silver</div>
            <?php elseif($user['user_tier'] == "3"): ?>
                <div class="user-tier" style="color: gold; background: #504420;" onclick="window.location.href='userTier.php'">Gold</div>
            <?php elseif($user['user_tier'] == "4"): ?>
                <div class="user-tier" style="color: lightblue; background: #202e50;" onclick="window.location.href='userTier.php'">Diamond</div>
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
          <div class="user-setting" onclick="window.location.href='logout.php'">
            Log out
          </div>
          <?php endif; ?>
        </div>
        <div class="user-cart">
          <div class="title" style="display: flex; justify-content: space-between; align-items: center; width: 78%; padding-top: 3%;">
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
                                <span style="font-size: clamp(.9rem, 1vw, 1.2rem);">Order totals (<?=$totalItems ?> items): <?=$items[0]['order_final_price']?>$</span>
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
                <span style="display: flex; align-items: center; justify-content: center; width: 55%;">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M149.1 64.8L138.7 96 64 96C28.7 96 0 124.7 0 160L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64l-74.7 0-10.4-31.2C356.4 45.2 338.1 32 317.4 32L194.6 32c-20.7 0-39 13.2-45.5 32.8zM256 192a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                    Virtual Try On AI
                </span>
                <img src="../AI/static/outputs/user_<?=$_SESSION['username']?>/<?=$to['result_img']?>" alt="">
                <div style="text-align: center; display: flex; width: 90%; height: 20%; justify-content: space-around; align-items: center; gap: 5%;">
                    <?=$to['created_at']?>
                    <form action="../Database/detele_user_tryon.php" method="POST">
                        <input type="text" name="id" value="<?=$to['id']?>" hidden>
                        <button type="submit" style="text-align: center; display: flex; justify-content: space-around; align-items: center;">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 448 512"><path d="M136.7 5.9C141.1-7.2 153.3-16 167.1-16l113.9 0c13.8 0 26 8.8 30.4 21.9L320 32 416 32c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 8.7-26.1zM32 144l384 0 0 304c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-304zm88 64c-13.3 0-24 10.7-24 24l0 192c0 13.3 10.7 24 24 24s24-10.7 24-24l0-192c0-13.3-10.7-24-24-24zm104 0c-13.3 0-24 10.7-24 24l0 192c0 13.3 10.7 24 24 24s24-10.7 24-24l0-192c0-13.3-10.7-24-24-24zm104 0c-13.3 0-24 10.7-24 24l0 192c0 13.3 10.7 24 24 24s24-10.7 24-24l0-192c0-13.3-10.7-24-24-24z"/></svg>    
                        Delete</button>
                    </form>
                </div>
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

      <button class="footer-btn" onclick="window.location.href='contact.php'">
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
        <a href="../Pages/">Home</a>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart</a>
        <a href="voucher.php">Vouchers</a>
        <a href="userTier.php">User Tier</a>
        <a href="#">About Us</a>
      </div>
      <div class="footer-col">
        <p class="footer-col-title">INFORMATION</p>
        <a href="../legal/term-of-service.php">Terms of Service</a>
        <a href="../legal/privacy-policy.php">Privacy Policy</a>
        <a href="../legal/delivery-policy.php">Delivery Policy</a>
        <a href="../legal/ai-usage-policy.php">AI Usage Policy</a>
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
<div id="product-modal">
  <div class="modal-container">
    <button id="closeModal">&times;</button>
    <img src="" alt="">
    <div id="modal-access">
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-320 280-520l56-58 104 104v-326h80v326l104-104 56 58-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z"/></svg>
    </div>
  </div>  
</div>


<div id="edit-info">
    <div class="info-container">
        <button id="closeEdit">&times;</button>
        <form action="../Database/user_info_update.php" method="POST" enctype="multipart/form-data">
            <h2>Edit Information</h2>
            <div class="edit-avatar">
                <label for="edit-avatar">
                    <?php if(empty($user['img'])): ?>
                        <img src="../Pictures/Banners/BA.webp" alt="" id="temp-avatar">
                    <?php else: ?>
                        <img src="../<?=$user['img']?>" alt="" id="temp-avatar">
                    <?php endif; ?>
                </label>
                <input type="file" id="edit-avatar" name="img" accept="image/*" hidden>
            </div>
            <div style="display: flex; width: 90%; justify-content: space-between;">
                <label for="user_sex">Sex:</label>
                <?php if($user['user_sex'] == "Male"): ?>
                    <select name="user_sex" id="user_sex">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                </select>
                <?php elseif($user['user_sex'] == "Female"): ?>
                    <select name="user_sex" id="user_sex">
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                        <option value="Other">Other</option>
                </select>
                <?php elseif($user['user_sex'] == "Other"): ?>
                    <select name="user_sex" id="user_sex">
                        <option value="Other">Other</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                </select>
                <?php endif; ?>
            </div>
            <div class="info-input-container">
                <label for="hotline">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M451.5-531.5Q440-543 440-560t11.5-28.5Q463-600 480-600t28.5 11.5Q520-577 520-560t-11.5 28.5Q497-520 480-520t-28.5-11.5ZM640-520q-17 0-28.5-11.5T600-560q0-17 11.5-28.5T640-600q17 0 28.5 11.5T680-560q0 17-11.5 28.5T640-520Zm160 0q-17 0-28.5-11.5T760-560q0-17 11.5-28.5T800-600q17 0 28.5 11.5T840-560q0 17-11.5 28.5T800-520Zm-2 400q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z"/></svg>
                    Hotline:
                </label>
                <input type="text" inputmode="numeric" placeholder="<?=$user['user_hotline']?>" name="user_hotline" pattern="0[0-9]{9}" maxlength="10" id="hotline">
            </div>
            <div class="info-input-container">
                <label for="hotline">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg>
                    Address:
                </label>
                    <div class="address-container">
                        <input type="text" placeholder="<?=$user['user_address']?>" id="address" name="user_address" oninput="search(this, 'toList')">
                        <div id="toList" class="suggest"></div>
                    </div>
            </div>
            <button type="submit" class="re-order">Update Information</button>
        </form>
    </div>
</div>
    <script>
      const email = <?= isset($_SESSION['username']) ? json_encode($_SESSION['username']) : '""' ?>;
      let username1 = email.replace("@gmail.com", "");
      const userWelcome = document.getElementById("menu-Username");
      const menuTitles = document.querySelectorAll(".menu-title");
      const imgPopup = document.querySelector(".line3 img");
      const modal = document.getElementById("product-modal");
      const conModal = document.querySelector(".modal-container");
      const closeModal = document.getElementById("closeModal");
      const imgEdit = document.querySelector(".user-avatar");
      const edit = document.getElementById("edit");

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
        });

        if(imgPopup){
            imgPopup.addEventListener('click', ()=>{
                modal.style.display = "flex";
                const modalImg = conModal.querySelector("img");
                modalImg.src = imgPopup.src;
            });
        }

        closeModal.addEventListener('click', ()=>{
            modal.style.display = "none";
        });

        modal.addEventListener('click', function(e){
            if(e.target === modal) modal.style.display = "none";
        });

        imgEdit.addEventListener('click', ()=>{
            document.getElementById("edit-info").style.display = "flex";
        });

        edit.addEventListener('click', ()=>{
            document.getElementById("edit-info").style.display = "flex";
        });

        document.getElementById("closeEdit").addEventListener('click', ()=>{
            document.getElementById("edit-info").style.display = "none";
        });

        const modalEdit = document.getElementById("edit-info");
        modalEdit.addEventListener('click', function(e){
            if(e.target === modalEdit) document.getElementById("edit-info").style.display = "none";
        });

        const fileInput = document.getElementById("edit-avatar");
        const preview = document.getElementById("temp-avatar");
        fileInput.addEventListener('change', function(){
            const file = this.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

const addressInput = document.getElementById("address");
const suggestBox = document.getElementById("toList");

addressInput.addEventListener("focus", () => {
  suggestBox.style.display = "block";
});

document.addEventListener("click", function(e){
  if (!e.target.closest(".address-container")) {
    suggestBox.style.display = "none";
  }
});

let coords = {
  from: [106.5775, 10.8908],
  to: null
};

async function search(input, listId){
  const q = input.value;
  if (q.length < 3) return;

  const res = await fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(q)}&limit=5`);
  const data = await res.json();

  const list = document.getElementById(listId);
  list.innerHTML = "";

  data.features.forEach(place => {
    const name = place.properties.name || place.properties.city || place.properties.country;
    const div = document.createElement("div");
    div.className = "item";
    div.innerText = name;

    div.onclick = () => {
      input.value = name;
      list.innerHTML = "";

      if (listId === "fromList") {
        coords.from = place.geometry.coordinates;
      } else {
        coords.to = place.geometry.coordinates;
      }
    };

    list.appendChild(div);
  });
}


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


const username = <?php echo json_encode($username); ?>;
console.log("USERNAME:", username);

if(username){
  const interval = setInterval(async () =>{
    try {
      const res = await fetch(`http://localhost:5000/api/progress/${username}`);
      const data = await res.json();

      console.log("DATA:", data);

      if(data.status === "done"){
        console.log("DONE TRIGGERED");
        clearInterval(interval);
        const goUser = confirm("Redirect to user page for result?");
        if(goUser){
          window.location.href = data.redirect;
        }
      }
    }catch (err){
      console.error(err);
    }
  }, 3000);
}
    </script>
  </body>
</html>

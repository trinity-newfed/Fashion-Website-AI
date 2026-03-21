<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();
//VOUNCHER FETCH
if(isset($_SESSION['username'])) {
    $voucher_id = $_GET['voucher_id'] ?? null;
    $stmt = $conn->prepare("SELECT * FROM voucher WHERE voucher_id = ?");
    $stmt->bind_param("s", $voucher_id);
    $stmt->execute();
    $vouncher = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $vouncher = [];
}



//CART FETCH
if(isset($_SESSION['username'])) {

$username = $_SESSION['username'];

$stmt = $conn->prepare("
SELECT 
    cart.id AS cart_id,
    cart.product_id,
    products.product_name,
    products.product_price,
    cart.product_color,
    products.product_category,
    products.product_img,
    cart.cart_size,
    cart.quantity
FROM cart
JOIN products 
    ON cart.product_id = products.id
WHERE cart.username = ?
");

$stmt->bind_param("s", $username);
$stmt->execute();
$data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);



} else {
    $data = [];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/cart.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
    <title>Trinity Style - Cart</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
</head>
<body>
<section id="body">
        <div id="cart-header">SHOPPING CART</div>
    <form action="../Database/checkout.php" method="POST" style="width: 100%; height: 100%; top: 12.5%; position: relative;">
        <div id="cart-item-container">
            <div id="item-list">
                <div id="item-info">
                    <span>Product</span>
                    <span></span>
                    <span></span>
                    <span>Price</span>
                    <span>Quantity</span>
                    <span>Total</span>
                </div>
                <?php if(empty($data)): ?>
                    <span style="position: relative; top: 20%; left: 40%; max-width: 20%; font-size: clamp(0.35rem, 1vw, 1rem); color: rgba(0, 0, 0, 0.3);">Your cart is empty</span>
                    <span onclick="window.location.href='products.php'" style="top: 20%; left: 39%; max-width: 20%; position: relative; top: 20%; font-size: clamp(0.35rem, 1vw, 1rem); color: rgba(0, 72, 255, 0.3); cursor: pointer;">[Continue shopping]</span>
                <?php else: ?>
                <?php foreach($data as $d): ?>
                <div class="items">
                    <input type="checkbox" class="item-checkbox" name="cart_ids[]" value="<?=$d['cart_id']?>">
                    <div id="items-image-container"><img src="../<?=$d['product_img']?>" onclick="window.location.href='detail.php?id=<?=$d['product_id']?>'"></div>
                    <div id="items-info-container">
                        <span style="font-weight: bolder;"><?=$d['product_name']?></span>
                        <span style="color: rgba(0, 0, 0, 0.5); font-weight: 400;"><?=$d['product_color']?> / <?=$d['cart_size']?></span>
                            <label for="remove-input" id="label-for-remove-input" onclick="window.location.href='../Database/delete_item_cart.php?id=<?=$d['cart_id']?>'">Remove</label>
                    </div>
                    <div class="items-price-container" style="font-size: clamp(0.35rem, 0.9vw, 1rem); width: 20%;">
                        <?=$d['product_price']?> $
                    </div>
                    <div id="items-quantity-container">
                            <button type="button" id="minus-input" class="operation-button" data-id="<?=$d['cart_id']?>" data-action="minus">-</button>
                        <span class="item-quantity"><?=$d['quantity']?></span>
                            <button type="button" id="plus-input" class="operation-button" data-id="<?=$d['cart_id']?>" data-action="plus">+</button>
                    </div>
                    <div class="items-total-container">
                        <span style="font-size: clamp(0.35rem, 0.9vw, 1rem); position: relative;">0</span>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div id="info-list">
                <div id="info-freeship">
                    <div id="freeship-progress-bar">
                        <div id="progress-bar">
                            <div id="shipping-icon-container">
                                <svg class="shipping-icon" viewBox="0 0 640 512" aria-hidden="true">
                                    <path d="M64 96c0-35.3 28.7-64 64-64h288c35.3 0 64 28.7 64 64v32h50.7c17 0 33.3 6.7 45.3 18.7L621.3 192c12 12 18.7 28.3 18.7 45.3V384c0 35.3-28.7 64-64 64h-3.3c-10.4 36.9-44.4 64-84.7 64s-74.2-27.1-84.7-64H300.7c-10.4 36.9-44.4 64-84.7 64s-74.2-27.1-84.7-64H128c-35.3 0-64-28.7-64-64v-48H24c-13.3 0-24-10.7-24-24s10.7-24 24-24h112c13.3 0 24-10.7 24-24s-10.7-24-24-24H24c-13.3 0-24-10.7-24-24s10.7-24 24-24h176c13.3 0 24-10.7 24-24s-10.7-24-24-24H24c-13.3 0-24-10.7-24-24S10.7 96 24 96h40zm512 192v-50.7l-45.3-45.3H480v96h96zM256 424a40 40 0 1 0-80 0 40 40 0 1 0 80 0zm232 40a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <label id="shipping-label">Buy more to enjoy Free Shipping</label>
                </div>
                <div id="info-total-order">
                    <div class="info-total-order-span-container">
                        <span>Vouncher</span>
                        <?php if(empty($vouncher)): ?>
                        <span>N/A</span>
                        <?php else: ?>
                        <select>
                            <option value="abc"></option>
                        </select>
                        <?php endif; ?>
                    </div>
                    <div class="info-total-order-span-container">
                        <span>Delivery fee</span>
                        <span id="deli-fee"></span>
                    </div>
                    <div class="info-total-order-span-container">
                        <span>Totals</span>
                        <?php if(empty($data)): ?>
                        <span id="final-total">0$</span>
                        <?php else: ?>
                        <span id="final-total">0$</span>
                        <?php endif; ?>
                    </div>       
                    <button type="submit" id="order-btn">Checkout</button>
                </div>
            </div>
        </div>
    </form>
    </section>
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
                <p onclick="window.location.href='user.php'" id="menu-Username"><?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account" onclick="window.location.href='user.php'">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
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
            <div onclick="window.location.href='voucher.php'">Check voucher</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">TRINITY TIER</div>
        <div class="submenu">
            <div onclick="window.location.href='userTier.php'">Check your shopping tier</div>
        </div>
    </div>
    <div class="menu-item">
        <div class="menu-title">ABOUT</div>
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
        const finalTotal = document.getElementById("final-total");
        
        if(userWelcome){
            userWelcome.textContent = "Hi, " + username1;
        }

    function calculateFinalTotal(){
        const items = document.querySelectorAll(".items");
        let total = 0;
        items.forEach(item =>{
            const checkbox = item.querySelector(".item-checkbox");
            let itemsTotal = item.querySelector(".items-total-container span");
            let price = item.querySelector(".items-price-container").textContent;
            let quantity = item.querySelector(".item-quantity").textContent;
            price = parseFloat(price.replace("$",""));
            quantity = parseInt(quantity);

            itemsTotal.textContent = quantity * price + "$";
            let itemTotal = price * quantity;

            if(checkbox.checked){
                total += itemTotal;
            }
        });
        finalTotal.textContent = total + "$";
        let freeShippingCalculate = total;
            if(freeShippingCalculate > 0){
                document.getElementById("progress-bar").style.width = `${freeShippingCalculate/7}%`;
                if(freeShippingCalculate > 700){
                    document.getElementById("deli-fee").textContent = "100% off";
                    document.getElementById("shipping-label").textContent = "Free Shipping";
                }else{
                    document.getElementById("deli-fee").textContent = `${parseFloat((freeShippingCalculate/7).toFixed(0))}% off`;
                    document.getElementById("shipping-label").textContent = "Buy $" + (700 - freeShippingCalculate) + " more enjoy Free Shipping";
                }
            }else{
                document.getElementById("progress-bar").style.width = "10%";
                document.getElementById("deli-fee").textContent = "";
                document.getElementById("shipping-label").textContent = "Buy more enjoy Free Shipping";
            }
    }

    const operationBtn = document.querySelectorAll(".operation-button");
    operationBtn.forEach(btn =>{
        btn.addEventListener('click', function(){
            btn.disabled = true;
            const id = this.dataset.id;
            const action = this.dataset.action;
            const item = btn.closest(".items");
            const quantities = item.querySelector(".item-quantity");

            let quantity = parseInt(quantities.textContent);

            if(action === "plus"){
                quantity++;
            }else if(action === "minus" && quantity > 1){
                quantity--;
            }else if(action === "minus" && quantity <= 1){
                location.reload();
            }

            quantities.textContent = quantity;
            fetch('../Database/cart_update.php', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `cart_id=${id}&action=${action}`
            })
            .then(() => {btn.disabled = false;
                        calculateFinalTotal();
            });
        });
    });
    


        document.querySelectorAll(".item-checkbox").forEach(checkbox =>{
            checkbox.addEventListener('change', calculateFinalTotal);
        });
        calculateFinalTotal();

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
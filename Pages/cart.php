<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();
//VOUNCHER FETCH
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT * FROM voucher WHERE username = ?");
    $stmt->bind_param("s", $username);
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
    products.product_color,
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
    <title>TRINITY CART</title>
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
                    <input type="checkbox" class="item-checkbox">
                    <div id="items-image-container"><img src="../<?=$d['product_img']?>" alt=""></div>
                    <div id="items-info-container">
                        <span style="font-weight: bolder;"></span>
                        <span style="color: rgba(0, 0, 0, 0.5); font-weight: 400;"><?=$d['product_color']?> / <?=$d['cart_size']?></span>
                        <form action="../Database/delete_item_cart.php" method="POST">
                            <label for="remove-input" id="label-for-remove-input">Remove</label>
                            <input type="text" name="id" value="<?=$d['cart_id']?>" hidden>
                            <input type="submit" id="remove-input" hidden>
                        </form>
                    </div>
                    <div class="items-price-container" style="font-size: clamp(0.35rem, 0.9vw, 1rem); width: 20%;">
                        <?=$d['product_price']?> $
                    </div>
                    <div id="items-quantity-container">
                        <form action="../Database/cart_update.php" method="post">
                            <input type="text" name="username" value="<?=$_SESSION['username']?>" hidden>
                            <input type="text" name="product_id" value="<?=$d['product_id']?>" hidden>
                            <input type="text" name="action" value="minus" hidden>
                            <button type="submit" id="minus-input" class="operation-button">-</button>
                        </form>
                        <span class="item-quantity"><?=$d['quantity']?></span>
                        <form action="../Database/cart_update.php" method="post">
                            <input type="text" name="username" value="<?=$_SESSION['username']?>" hidden>
                            <input type="text" name="product_id" value="<?=$d['product_id']?>" hidden>
                            <input type="text" name="action" value="plus" hidden>
                            <button type="submit" id="plus-input" class="operation-button">+</button>
                        </form>
                    </div>
                    <div class="items-total-container">
                        <span style="font-size: clamp(0.35rem, 0.9vw, 1rem); position: relative; left: 70%;">0</span>
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
                    <div id="order-btn">Check out</div>
                </div>
            </div>
        </div>
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
        let email = "abc@gmail.com";
        let username1 = email.replace("@gmail.com", "");
        document.getElementById("menu-Username").textContent = "Hi, " + username1;
        const items = document.querySelectorAll(".items");
        const finalTotal = document.getElementById("final-total");

    function calculateFinalTotal(){
        let total = 0;
        items.forEach(item =>{
            const checkbox = item.querySelector(".item-checkbox");
            let itemsTotal = item.querySelector(".items-total-container");
            let price = item.querySelector(".items-price-container").textContent;
            let quantity = item.querySelector(".item-quantity").textContent;
            price = parseInt(price.replace("$",""));
            quantity = parseInt(quantity);

            itemsTotal.textContent = quantity * price + "$";
            let itemTotal = price * quantity;

            if(checkbox.checked){
                total += itemTotal;
            }
        });
        finalTotal.textContent = total + "$";
            let freeShippingCalculate = total + 100;
            if(freeShippingCalculate >= 0){
                document.getElementById("progress-bar").style.width = `${freeShippingCalculate/10}%`;
                if(freeShippingCalculate >= 1000){
                    document.getElementById("shipping-label").textContent = "Free Shipping";
                }else if(freeShippingCalculate < 1000){
                    document.getElementById("deli-fee").textContent = `${freeShippingCalculate/10}% off`;
                    document.getElementById("shipping-label").textContent = "Buy more to enjoy Free Shipping";
                }
            }
    }
        document.querySelectorAll(".item-checkbox").forEach(checkbox =>{
            checkbox.addEventListener("change", calculateFinalTotal);
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
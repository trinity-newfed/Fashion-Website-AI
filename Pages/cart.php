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
    $stmt = $conn->prepare("SELECT * FROM vouncher WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $vouncher = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $vouncher = [];
}
//CART FETCH
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $stmt = $conn->prepare("SELECT cart.id AS cart_id, 
                                   cart.quantity, 
                                   product_id AS product_id, 
                                   product_name, product_price, 
                                   product_img 
    FROM cart
    INNER JOIN products 
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
    <title>Document</title>
</head>
<body>
    <section id="menu">
        <div id="text-menu">
            <div id="logo">T</div>
            <div id="text">
                <span>New Arrival</span>
                <span>Tops</span>
                <span id="t-bottoms">Bottoms</span>
                <span>Accesorires</span>
                <span>About</span>
            </div>
        </div>
        <div id="utility-menu">
            <svg class="icon" viewBox="0 0 640 512" aria-hidden="true">
                <path fill="currentColor" d="M24 0C10.7 0 0 10.7 0 24s10.7 24 24 24h45.3c3.9 0 7.2 2.8 7.9 6.6l52.1 286.3C135.5 375.1 165.3 400 200.1 400H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H200.1c-11.6 0-21.5-8.3-23.6-19.7l-5.1-28.3h303.6c30.8 0 57.2-21.9 62.9-52.2L568.9 85.9C572.6 66.2 557.5 48 537.4 48H124.7l-.4-2C119.5 19.4 96.3 0 69.2 0H24zm184 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm224 0a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/>
            </svg>
            <?php if(isset($_SESSION['username'])): ?>
                <p><?=$_SESSION['username']?></p>
                <?php if(!empty($_SESSION['img'])): ?>
                    <div id="user-account">
                        <img id="user-avatar" src="../upload/<?= htmlspecialchars($_SESSION['img']) ?>" alt="avatar">
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
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
                    <span onclick="window.location.href='product.php'" style="top: 20%; left: 39%; max-width: 20%; position: relative; top: 20%; font-size: clamp(0.35rem, 1vw, 1rem); color: rgba(0, 72, 255, 0.3);">[Continue shopping]</span>
                <?php else: ?>
                <?php foreach($data as $d): ?>
                <div class="items">
                    <div id="items-image-container"><img src="../picture-upload/<?=$d['']?>" alt=""></div>
                    <div id="items-info-container">
                        <span style="font-weight: bolder;"></span>
                        <span style="color: rgba(0, 0, 0, 0.5); font-weight: 400;">Black / S</span>
                        <span style="text-decoration: underline;">Remove</span>
                    </div>
                    <div id="items-price-container" style="font-size: clamp(0.35rem, 0.9vw, 1rem); width: 20%;">250$</div>
                    <div id="items-quantity-container" style="font-size: clamp(0.35rem, 0.9vw, 1rem); width: 8%; display: flex; justify-content: space-between;">
                        <form action="minus_items_cart" method="post">
                            <input type="submit" id="minus-input" hidden>
                            <label for="minus-input">-</label>
                        </form>
                        <span>1</span>
                        <form action="plus_items_cart" method="post">
                            <input type="submit" id="plus-input" hidden>
                            <label for="plus-input">+</label>
                        </form>
                    </div>
                    <div id="items-total-container" style="font-size: clamp(0.35rem, 0.9vw, 1rem); width: 15%; display: flex; justify-content: center;">
                        <span style="font-size: clamp(0.35rem, 0.9vw, 1rem); position: relative; left: 70%;">1</span>
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
                        <?php if(empty($data)): ?>
                        <span>0$</span>
                        <?php else: ?>
                        <span></span>
                        <?php endif; ?>
                    </div>
                    <div class="info-total-order-span-container">
                        <span>Totals</span>
                        <?php if(empty($data)): ?>
                        <span>0$</span>
                        <?php else: ?>
                        <span></span>
                        <?php endif; ?>
                    </div>
                    <div id="order-btn">Check out</div>
                </div>
            </div>
        </div>
    </section>
    <script>
        const item_total = document.getElementById("items-total-container");
    </script>
</body>
</html>
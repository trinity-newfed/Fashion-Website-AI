<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("Lỗi kết nối".$conn->error);
}

session_start();

$id = $_GET['id'] ?? 0;
$id = intval($id);

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

if($result->num_rows>0){
    echo "";
}else{
    echo "No infomation";
}

while($row = $result->fetch_assoc()){
    $data[] = $row;
}
$result->close();

$product = "SELECT * FROM products";
$ptmt = $conn->query($product);

if($ptmt->num_rows>0){
    echo"";
}else{
    echo"No products are recommended";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/detail.css">
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
    <?php foreach($data as $row): ?>
    <title>Trinity <?=$row['product_name']?></title>
    <?php endforeach; ?>
    <link
      href="https://fonts.googleapis.com/css2?family=Birthstone&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
</head>
<style>
body{
    font-family: Arial, Helvetica, sans-serif;
    background:#f8f8f8;
    margin:0;
}




/* CONTAINER */
.product-container{
    max-width:1200px;
    position: relative;
    margin: auto;
    display:flex;
    gap:60px;
    padding:60px 20px;
    background:white;
}




/* LEFT */
.product-left{
    width:50%;
}
.product-left img{
    width:80%;
    height: 80%;   
    border-radius:10px;
    object-fit:cover;
}
.thumb-list{
    display:flex;
    gap:10px;
    margin-top:15px;
}
.thumb-list img{
    width:80px;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}
.thumb-list img:hover{
    transform:scale(1.08);
}




/* RIGHT */
.product-right{
    width:50%;
}
.product-title{
    font-size:28px;
    margin-bottom:10px;
}
.price{
    font-size:30px;
    color:#e60023;
    font-weight:bold;
    margin:15px 0;
}
.short-desc{
    color:#666;
    line-height:1.6;
}




/* SIZE */
.size{
    margin-top:30px;
}
.size .label{
    font-weight:600;
    margin-bottom:10px;
}
.size-list{
    display:flex;
    gap:10px;
}
.size {
  display: flex;
  gap: 15px;
  margin-bottom: 40px;
}

.size label {
  width: 40px;
  height: 40px;
  border: 1px solid black;
  display: grid;
  place-items: center;
  cursor: pointer;
  transition: 0.3s;
}

.size label:hover,
.size label.active {
  background: black;
  color: white;
}




/* SELECT */
.size-list button.active{
    background:black;
    color:white;
}




/* QUANTITY */
.quantity{
    display:flex;
    align-items:center;
    margin-top:30px;
}
.quantity button{
    border: none;
    background: white;
}
.quantity input{
    width:60px;
    height:20px;
    text-align:center;
    border:1px solid #ddd;
}
.qty-btn{
    width:40px;
    height:40px;
    border:1px solid #ddd;
    background:white;
    cursor:pointer;
}




/* CART */
.add-cart{
    margin-top:30px;
    width:100%;
    padding:16px;
    border:none;
    background:black;
    color:white;
    font-size:16px;
    cursor:pointer;
    border-radius:6px;
    transition:0.3s;
}
.add-cart:hover{
    background:#333;
}




#body{
    width: 100vw;
    height: 100svh;
    max-width: 1500px;
    max-height: 900px;
}
#simillar-product-container{
    width: 100%;
    height: 100%;
    display: grid;
    place-items: center;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 20px;
}
.items{
    width: 320px;
    height: 200px;
    border: 1px solid black;
    display: flex;
    transition: .1s all;
}
.items:hover{
    scale: 1.04;
    transition: .4s all;
}
.items:hover #items-left img{
    filter: brightness(50%);
}
#items-left{
    background-color: whitesmoke;
}
#items-left img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
#items-right{
    display: flex;
    flex-direction: column;
    margin-left: 30px;
}
#items-right span{
    font-size: 13px;
}
#items-right p{
    color: rgba(0, 0, 0, 0.7);
    font-size: 13px;
}
</style>
<body>
    <div class="product-container">

<div class="product-left">
        <?php foreach($data as $row): ?>
            <span id="mainType" data-type="<?=$row['product_type']?>"></span>
            <span id="mainColor" data-color="<?=$row['product_color']?>"></span>
            <?php if(!empty($row['product_img'])): ?>
                <img src="../<?=$row['product_img']?>">
            <?php endif; ?>
    <div class="thumb-list">
            <?php if(!empty($row['product_img1'])): ?>
                <img src="../<?=$row['product_img1']?>">
            <?php endif; ?>
            <?php if(!empty($row['product_img2'])): ?>
                <img src="../<?=$row['product_img2']?>">
            <?php endif; ?>
    </div>
        <?php endforeach; ?>

</div>
    <div class="product-right">
        <?php foreach($data as $row): ?>
            <span id="mainId" style="display: none;" data-id="<?=$row['id']?>"></span>
            <span id="mainType" style="display: none;" data-type="<?=$row['product_type']?>"></span>
            <span id="mainColor" style="display: none;" data-color="<?=$row['product_color']?>"></span>
        <h1>Trinity <?=$row['product_name']?></h1>
        <div class="price"><?=$row['product_price']?>$</div>

        <p class="short-desc">
            <?=$row['product_describe']?>
        </p>
        <p>Size</p>
        <div class="size">       
                <label for="S-size-<?=$row['id']?>">S</label>
                <label for="M-size-<?=$row['id']?>">M</label>        
                <label for="L-size-<?=$row['id']?>">L</label>        
                <label for="XL-size-<?=$row['id']?>">XL</label>
        </div>

        <div class="quantity">
            <button>-</button>
            <input value="1">
            <button>+</button>
        </div>
        <form action="../Database/add_item_to_cart.php" method="POST" style="width: 100%; display: grid; place-items: center;">     
                    <input type="hidden" name="product_id" value="<?=$row['id']?>" id="modal-product-id">
                    <input type="hidden" name="product_name" value="<?=$row['product_name']?>" id="modal-product-name">
                    <input type="hidden" name="product_category" value="<?=$row['product_category']?>" id="modal-product-type">
                    <input type="hidden" name="product_color" value="<?=$row['product_color']?>" id="modal-product-color">
                    <input type="radio" name="cart_size" value="S" id="S-size-<?=$row['id']?>" hidden checked>
                    <input type="radio" name="cart_size" value="M" id="M-size-<?=$row['id']?>" hidden>
                    <input type="radio" name="cart_size" value="L" id="L-size-<?=$row['id']?>" hidden>
                    <input type="radio" name="cart_size" value="XL" id="XL-size-<?=$row['id']?>" hidden> 
        <button class="add-cart">Add to cart</button>
        </form>
        <?php endforeach; ?>
    </div>

</div>
<section id="body">
    <h1>Simillar product</h1>
    <div id="simillar-product-container">
        <?php foreach($ptmt as $p): ?>
            <div onclick="window.location.href='detail.php?id=<?=$p['id']?>'" class="items" data-type="<?=$p['product_type']?>" data-color="<?=$p['product_color']?>" data-id="<?=$p['id']?>">
                <div id="items-left">
                    <img src="../<?=$p['product_img']?>" alt="">
                </div>
                <div id="items-right">
                    <h5><?=$p['product_name']?></h5>
                    <span><?=$p['product_price']?>$</span>
                    <p><?=$p['product_color']?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div id=""></div>
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
</body>
<script>
    let email = "abc@gmail.com";
    let username1 = email.replace("@gmail.com", "");
    document.getElementById("menu-Username").textContent = "Hi, " + username1;
    const items = document.querySelectorAll(".items");
    const mainId = document.getElementById("mainId").dataset.id;
    const mainType = document.getElementById("mainType").dataset.type;
    const mainColor = document.getElementById("mainColor").dataset.color;
    const sizeAdd = document.querySelectorAll(".size label");

    items.forEach(item =>{
        const type = item.dataset.type;
        const color = item.dataset.color;
        const id = item.dataset.id;
        if(type == mainType && id != mainId){
            item.style.display = "flex";
        }else{
            item.style.display = "none";
        }
    });

    sizeAdd.forEach(label =>{
        label.addEventListener('click', ()=>{
            sizeAdd.forEach(lb =>{
                lb.style.color = "black";
                lb.style.background = "white";
            });
        label.style.color = "white";
        label.style.background = "black";
        });
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
</script>
</html>
<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("Lỗi kết nối".$conn->error);
}

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
    <title>Document</title>
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
</body>
<script>
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
</script>
</html>
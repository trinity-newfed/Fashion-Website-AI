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
    echo "Chưa có thông tin";
}

while($row = $result->fetch_assoc()){
    $data[] = $row;
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


/* container */

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

.size button{
    width:50px;
    height:45px;

    border:1.5px solid black;
    background:white;

    font-size:14px;
    font-weight:600;

    cursor:pointer;

    transition:0.25s;
}

/* hover giống brand lớn */

.size button:hover{
    background:black;
    color:white;
}

/* khi chọn */

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


/* ADD CART */

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


</style>
<body>
    <div class="product-container">

<div class="product-left">
        <?php foreach($data as $row): ?>
            <?php if(!empty($row['product_img'])): ?>
                <img src="../picture-uploads/<?=$row['product_img']?>">
            <?php endif; ?>
    <div class="thumb-list">
            <?php if(!empty($row['product_img1'])): ?>
                <img src="../picture-uploads/<?=$row['product_img1']?>">
            <?php endif; ?>

            <?php if(!empty($row['product_img2'])): ?>
                <img src="../picture-uploads/<?=$row['product_img2']?>">
            <?php endif; ?>

            <?php if(!empty($row['product_img3'])): ?>
                <img src="../picture-uploads/<?=$row['product_img3']?>">
            <?php endif; ?>
    </div>
        <?php endforeach; ?>

</div>
    <div class="product-right">
        <?php foreach($data as $row): ?>
        <h1>Trinity <?=$row['product_name']?></h1>
        <div class="price"><?=$row['product_price']?>$</div>

        <p class="short-desc">
            <?=$row['product_describe']?>
        </p>

        <div class="size">
            <p>Size</p>
            <button>S</button>
            <button>M</button>
            <button>L</button>
            <button>XL</button>
        </div>

        <div class="quantity">
            <button>-</button>
            <input value="1">
            <button>+</button>
        </div>
        <?php endforeach; ?>
        <button class="add-cart">Add to cart</button>

    </div>

</div>

</body>
</html>
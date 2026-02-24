
<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("error" .$conn->connect_error);
}

$products = $conn
  ->query("SELECT * FROM products")
  ->fetch_all(MYSQLI_ASSOC);
  
$projects = $conn
  ->query("SELECT * FROM projects")
  ->fetch_all(MYSQLI_ASSOC);
  
$employee = $conn
  ->query("SELECT * FROM employeedata")
  ->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html, body{
            width: 100%;
            height: 800px;
            position: relative;
            margin: auto;
            user-select: none;
        }
        #header{
            width: 100%;
            height: 100px;
            max-width: 1500px;
            position: absolute;
            background-color: black;
            color: white;
            z-index: 10;
            left: 50%;
            transform: translateX(-50%);
            border: 1px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 90px;
            font-weight: bold;
        }
        #container{
            width: 1500px;
            height: 1000px;
            display: flex;
            position: relative;
            margin: auto;
            justify-content: space-between;
        }
        #section-menu{
            width: 300px;
            height: 91%;
            padding-top: 200px;
            border: 2px solid black;
            border-right: 0;
            background-color: white;
            position: relative;
            z-index: 1;
        }
        #section-menu :nth-child(1){
            margin-top: 0;
        }
        .option{
            margin-top: 5px;
            width: 100%;
            height: 50px;
            border: 1px solid black;
            border-left: 0;
            border-right: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .option:hover{
            background-color: whitesmoke;
        }
        .product{
            top: 100px;
            width: 100%;
            height: 100%;
            max-width: 1600px;
            padding-left: 50px;
            padding-top: 10px;
            position: relative;
            border: 2px solid black;
            display: grid;
            grid-template-columns: repeat(5, 150px);
            grid-template-rows: repeat(20, 220px);
            gap: 60px;
        }
        .box{
            width: 180px;
            height: 250px;
            display: grid;
            place-items: center;
            text-align: center;
        }
        .box img{
            width: 150px;
            height: 200px;
            object-fit: cover;
            object-position: 20% 65%;
        }
        .product-id{
            display: none;
        }
        .add-products{
            top: 80%;
            position: absolute;
        }
    </style>
</head>
<body>
    <div id="header">Admin Manager Page</div>
    <div id="container">
    <div id="section-menu">
        <div class="option" id="b1">Products</div>
        <div class="option" id="b2">Projects</div>
        <div class="option" id="b3">Employee</div>
    </div>
    <div class="product" id="p1">
        <?php foreach($products as $p): ?>
            <div class="box">
                <div class="product-id"><?=$p['id']?></div>
                <img src="/Real Estate/pictures/<?=$p['product_img']?>">
                <p><?=$p['product_describe']?>|| Diện tích <?=$p['product_size']?></p>
                <button onclick="window.location.href='deleteitem.php?id=<?=$p['id']?>'">Xóa</button>
            </div>
        <?php endforeach ?>
        <div class="add-products">
            <span>Thêm sản phẩm cho bảng products</span>
            <form action="additem.php" method="post">
                <input type="text" placeholder="Nhập tên" name="product_name">
                <input type="text" placeholder="Nhập giá" name="product_price">
                <input type="text" placeholder="Nhập loại" name="product_type">
                <input type="text" placeholder="Nhập trạng thái" name="product_state">
                <input type="text" placeholder="Địa chỉ" name="product_address">
                <input type="text" placeholder="Mô tả" name="product_describe">
                <input type="text" placeholder="Diện tích" name="product_size">
                <div style="display: grid;">
                    <input type="file" placeholder="Ảnh" name="product_img">
                    <input type="file" placeholder="Ảnh 1" name="product_img1">
                    <input type="file" placeholder="Ảnh 2" name="product_img2">
                    <input type="file" placeholder="Ảnh 3" name="product_img3">
                    <input type="file" placeholder="Ảnh 4" name="product_img4">
                </div>
                <input type="submit" value="gửi">
            </form>
        </div>
    </div>
    <div class="product" id="p2">
        <?php foreach($projects as $p): ?>
            <div class="box">
                <div class="product-id"><?=$p['id']?></div>
                <img src="/Real Estate/pictures/<?=$p['project_img']?>">
                <p><?=$p['product_describe']?>||Kích thước <?=$p['project_size']?></p>
                <button onclick="window.location.href='project_delete.php?id=<?=$p['id']?>'">Xóa</button>
            </div>
        <?php endforeach ?>
        <div class="add-products">
            <span>Thêm sản phẩm cho bảng project</span>
            <form action="add_project.php" method="post">
                <input type="text" placeholder="Nhập tên" name="project_name">
                <input type="text" placeholder="Mô tả" name="project_describe">
                <div style="display: grid;">
                    <input type="file" placeholder="Ảnh" name="project_img">
                    <input type="file" placeholder="Ảnh 1" name="project_img1">
                    <input type="file" placeholder="Ảnh 2" name="project_img2">
                    <input type="file" placeholder="Ảnh 3" name="project_img3">
                </div>
                <input type="submit" value="gửi">
            </form>
        </div>
    </div>
    <div class="product" id="p3">
        <?php foreach($employee as $p): ?>
            <div class="box">
                <div class="product-id"><?=$p['id']?></div>
                <img src="/Real Estate/pictures/<?=$p['img']?>">
                <span><?=$p['name']?>|| <?=$p['email']?></span>
                <span>Điện thoại: <?=$p['hotline']?>|| Thêm vào ngày <?=$p['created_at']?></span>
                <p>Đánh giá: <?=$p['rating']?></p>
                <div style="display: flex; gap: 10px;">
                    <button onclick="window.location.href='delete_employee.php?id=<?=$p['id']?>'">Xóa</button>
                    <button onclick="window.location.href='update.php?id=<?=$p['id']?>'">Cập nhật</button>
                </div>
            </div>
        <?php endforeach ?>
        <div class="add-products">
            <span>Thêm sản phẩm cho bảng employee</span>
            <form action="add_employee.php" method="post">
                <input type="text" placeholder="Nhập tên" name="name">
                <input type="text" placeholder="Nhập mail" name="email">
                <input type="text" placeholder="Mô tả" name="address">
                <input type="text" placeholder="Số điện thoại" name="hotline">
                <input type="text" placeholder="Đánh giá" name="rating">
                <div style="display: grid;">
                    <input type="file" placeholder="Ảnh" name="img">
                </div>
                <input type="submit" value="gửi">
            </form>
        </div>
    </div>
    </div>
    <script>
        const p1 = document.getElementById("p1");
        const p2 = document.getElementById("p2");
        const p3 = document.getElementById("p3");
        const b1 = document.getElementById("b1");
        const b2 = document.getElementById("b2");
        const b3 = document.getElementById("b3");
        const option = document.querySelectorAll(".option");

            b1.classList.add("active");
            p1.style.display = "";
            p2.style.display = "none";
            p3.style.display = "none";
            b1.style.background = "black";
            b2.style.background = "white";
            b3.style.background = "white";
            b1.style.color = "white";
            b2.style.color = "black";
            b3.style.color = "black";

        option.forEach(o => o.addEventListener('click', ()=>{
            option.forEach(ops => ops.classList.remove("active"))
            o.classList.add("active");
        }));

        b1.addEventListener('click', ()=>{
            if(b1.classList.contains("active")){
            b1.style.background = "black";
            b2.style.background = "white";
            b3.style.background = "white";
            b1.style.color = "white";
            b2.style.color = "black";
            b3.style.color = "black";
            p1.style.display = "";
            p2.style.display = "none";
            p3.style.display = "none";
        }
        });
        b2.addEventListener('click', ()=>{
            if(b2.classList.contains("active")){
            b1.style.background = "white";
            b2.style.background = "black";
            b3.style.background = "white";
            b1.style.color = "black";
            b2.style.color = "white";
            b3.style.color = "black";
            p1.style.display = "none";
            p2.style.display = "";
            p3.style.display = "none";
        }
        });
        b3.addEventListener('click', ()=>{
            if(b3.classList.contains("active")){
            b1.style.background = "white";
            b2.style.background = "white";
            b3.style.background = "black";
            b1.style.color = "black";
            b2.style.color = "black";
            b3.style.color = "white";
            p1.style.display = "none";
            p2.style.display = "none";
            p3.style.display = "";
        }
        });
        
    </script>
</body>
</html>
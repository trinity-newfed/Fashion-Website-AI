<?php
session_start();
$conn = new mysqli("localhost", "root", "", "TF_Database");
if ($conn->connect_error) {
    die("error" . $conn->connect_error);
}
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== "admin"){
    $_SESSION['error'] = "Restrict permission!";
    header("Location: ../Pages/");
    exit();
}
$id = $_GET['id'];
$products = $conn->query("SELECT * FROM products WHERE id = $id")
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Admin</title>
<link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    padding: 40px;
}

.container {
    max-width: 900px;
    margin: auto;
}

.card {
    background: #fff;
    padding: 24px;
    margin-bottom: 30px;
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
}

.card h2 {
    margin-bottom: 20px;
    color: #333;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 14px;
    margin-bottom: 6px;
    color: #555;
}

input {
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
}

input:focus {
    outline: none;
    border-color: #4f46e5;
}

.avatar {
    grid-column: span 2;
    display: flex;
    align-items: center;
    gap: 16px;
}

.avatar img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: scale-down;
    border: 2px solid #eee;
    background: #b2b2b2;
}

button {
    margin-top: 20px;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: black;
    color: #fff;
    font-size: 15px;
    cursor: pointer;
}

button:hover {
    background: gray;
}
</style>
</head>

<body>
<div class="container">

<?php foreach ($products as $row): ?>
<form action="update_employee.php" method="post" enctype="multipart/form-data">

<div class="card">
    <h2>Product Update #<?= $row['id']?></h2>

    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="hidden" name="old_img" value="../<?=$row['product_img'] ?>">

    <div class="form-grid">

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" value="<?= $row['product_name']?>">
        </div>

        <div class="form-group">
            <label>Product Price</label>
            <input type="email" name="email" value="<?= $row['product_price'] ?>">
        </div>

        <div class="form-group">
            <label>Product Type</label>
            <input type="text" name="address" value="<?= $row['product_type'] ?>">
        </div>

        <div class="form-group">
            <label>Product Describe</label>
            <input type="text" name="hotline" value="<?= $row['product_describe'] ?>">
        </div>

        <div class="form-group">
            <label>Product Color</label>
            <input type="text" name="rating" value="<?= $row['product_color'] ?>">
        </div>
        <div class="avatar">
            <img src="../<?= $row['product_img'] ?>">
        </div>
    </div>
    <button type="submit">Update</button>
</div>
</form>
<?php endforeach; ?>

<?php foreach ($products as $row): ?>
<form action="update_employee_img.php" method="post">
    <div class="form-group">
        <label>New Image</label>
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="file" placeholder="Ảnh" name="img" value="img3.jpg">
    </div>
    <button style="left: 10px; position: relative;" type="submit">Update Image</button>
</form>
<?php endforeach; ?>
</div>
</body>
</html>

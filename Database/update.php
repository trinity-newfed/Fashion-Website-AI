<?php
session_start();
$conn = new mysqli("localhost", "root", "", "RS_Database");
if ($conn->connect_error) {
    die("error" . $conn->connect_error);
}

$employee = $conn
  ->query("SELECT * FROM employeedata")
  ->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Employee</title>

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
    object-fit: cover;
    border: 2px solid #eee;
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

<?php foreach ($employee as $row): ?>
<form action="update_employee.php" method="post" enctype="multipart/form-data">

<div class="card">
    <h2>Cập nhật nhân viên #<?= $row['id'] ?></h2>

    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="hidden" name="old_img" value="<?= $row['img'] ?>">

    <div class="form-grid">

        <div class="form-group">
            <label>Họ tên</label>
            <input type="text" name="name" value="<?= $row['name'] ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= $row['email'] ?>">
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <input type="text" name="address" value="<?= $row['address'] ?>">
        </div>

        <div class="form-group">
            <label>Hotline</label>
            <input type="text" name="hotline" value="<?= $row['hotline'] ?>">
        </div>

        <div class="form-group">
            <label>Rating</label>
            <input type="text" name="rating" value="<?= $row['rating'] ?>">
        </div>
        <div class="avatar">
            <img src="../../pictures/<?= $row['img'] ?>">
        </div>
    </div>
    <button type="submit">Cập nhật</button>
</div>
</form>
<?php endforeach; ?>

<?php foreach ($employee as $row): ?>
<form action="update_employee_img.php" method="post">
    <div class="form-group">
        <label>Ảnh mới</label>
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="file" placeholder="Ảnh" name="img" value="img3.jpg">
    </div>
    <button style="left: 10px; position: relative;" type="submit">Cập nhật ảnh</button>
</form>
<?php endforeach; ?>
</div>
</body>
</html>

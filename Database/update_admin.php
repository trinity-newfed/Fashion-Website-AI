<?php
$conn = new mysqli("localhost", "root", "", "TF_Database");
if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

$id      = $_POST['id'];
$name    = $_POST['product_name'];
$email   = $_POST['product_price'];
$address = $_POST['product_type'];
$hotline = $_POST['product_describe'];
$rating  = $_POST['product_color'];

$sql = "UPDATE products SET
            product_name    = '$name',
            product_price   = '$email',
            product_type = '$address',
            product_describe = '$hotline',
            product_color  = '$rating'
        WHERE id = $id";

if ($conn->query($sql)) {
    header("Location: admin.php");
    exit();
} else {
    echo "Lỗi: " . $conn->error;
}

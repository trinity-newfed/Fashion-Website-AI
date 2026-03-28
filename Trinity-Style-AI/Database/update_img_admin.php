<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

$id  = $_POST['id'];
$img = $_POST['product_img'];

$sql = "UPDATE products SET
            product_img = '$img'
        WHERE id = $id";

if ($conn->query($sql)) {
    header("Location: update.php");
    exit();
} else {
    echo "Lỗi: " . $conn->error;
}
?>
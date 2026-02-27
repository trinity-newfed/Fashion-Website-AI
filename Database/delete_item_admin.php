<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối DB");
}

if (!isset($_POST['id'])) {
    die("ID REQUIRED!");
}

$id = $_POST['id'];

$sql = "UPDATE products SET product_is_delete = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin.php");
    exit();
} else {
    echo "Xoá thất bại";
}

$stmt->close();
$conn->close();
?>
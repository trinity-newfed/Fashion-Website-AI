<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();


if(isset($_GET['id']) && isset($_SESSION['username'])) {
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $_GET['id'], $_SESSION['username']);
    $stmt->execute();
}

if($stmt->execute()){
    header("Location: ../Pages/cart.php");
    exit();
}else{
    echo "Xoá thất bại";
}

$stmt->close();
$conn->close();
?>
<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("error " . $conn->connect_error);
}
$cart_ids = $_POST['cart_ids'];
$_SESSION['checkout_cart_ids'] = $cart_ids;

if(empty($_SESSION['checkout_cart_ids'])){
    echo "<script>alert('No items selected!');
                  window.location.href='../Pages/cart.php';
          </script>";
}else{
    header("Location: ../Pages/payment.php");
    exit;
}
?>
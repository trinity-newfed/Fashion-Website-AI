<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";
$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("error" .$conn->connect_error);
}

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../Pages/log.php");
    exit();
}

$username = $_SESSION['username'];
$product_id = $_POST['product_id'];
$cart_size = $_POST['cart_size'];
$quantity = 1;

$sql = "SELECT * FROM cart WHERE username = ? AND product_id = ? AND cart_size = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $username, $product_id, $cart_size);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $sql = "UPDATE cart 
            SET quantity = quantity + 1 
            WHERE username = ? AND product_id = ? AND cart_size = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $username, $product_id, $cart_size);
    $stmt->execute();
}else{
    $sql = "INSERT INTO cart (username, product_id, cart_size, quantity)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $username, $product_id, $cart_size, $quantity);
    $stmt->execute();
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>

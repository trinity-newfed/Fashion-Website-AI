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

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Pages/log.php");
    exit();
}

$userID = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$product_category = $_POST['product_category'];
$product_color = $_POST['product_color'];
$cart_size = $_POST['cart_size'];
$quantity = 1;

$sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND product_category = ? AND product_color = ? AND cart_size = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisss", $userID, $product_id, $product_category, $product_color, $cart_size);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $sql = "UPDATE cart 
            SET quantity = quantity + 1 
            WHERE user_id = ? AND product_id = ? AND product_category = ? AND product_color = ? AND cart_size = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $userID, $product_id, $product_category, $product_color, $cart_size);
    $stmt->execute();
}else{
    $sql = "INSERT INTO cart (user_id, product_id, product_category, product_color, cart_size, quantity)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $userID, $product_id, $product_category, $product_color, $cart_size, $quantity);
    $stmt->execute();
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>

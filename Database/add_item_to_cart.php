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
$product_type = $_POST['product_type'];
$quantity = 1;

$sql = "SELECT * FROM cart WHERE username = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $username, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $sql = "UPDATE cart 
            SET quantity = quantity + 1 
            WHERE username = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $product_id);
    $stmt->execute();
}else{
    $sql = "INSERT INTO cart (username, product_id, quantity)
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $username, $product_id, $quantity);
    $stmt->execute();
}
header("Location: ../Pages/products.php");
exit();
?>

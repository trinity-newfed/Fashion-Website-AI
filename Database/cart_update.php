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
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$product_id = $_POST['product_id'];
$action = $_POST['action'];

if($action === "plus"){
    $stmt = $conn->prepare($sql = "UPDATE cart 
                                   SET quantity = quantity + 1
                                   WHERE username = ? AND product_id = ?"
                            );
    $stmt->bind_param("si", $username, $product_id);
    $stmt->execute();
    $stmt->close();
}elseif($action === "minus"){
    $stmt = $conn->prepare($sql = "UPDATE cart 
                                   SET quantity = quantity - 1
                                   WHERE username = ? 
                                   AND product_id = ? 
                                   AND quantity > 1"
                           );
    $stmt->bind_param("si", $username, $product_id);
    $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();
if($affected === 0){
    $stmt = $conn->prepare("DELETE 
                            FROM cart 
                            WHERE username = ? AND product_id = ?");
    $stmt->bind_param("si", $username, $product_id);
    $stmt->execute();
    $stmt->close();
}
}
header("Location: ../Pages/cart.php");
exit();
?>

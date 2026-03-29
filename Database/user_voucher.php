<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "TF_DATABASE";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$userID = $_SESSION['user_id'];
$voucher_id = $_POST['voucher_id'];

$check = $conn->prepare("SELECT * FROM user_voucher WHERE user_id = ? AND voucher_id = ?");

$check->bind_param("ii", $userID, $voucher_id);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
$stmt = $conn->prepare("
    INSERT INTO user_voucher (user_id, voucher_id)
    VALUES (?, ?)
");
$stmt->bind_param("ii", $userID, $voucher_id);
$stmt->execute();

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
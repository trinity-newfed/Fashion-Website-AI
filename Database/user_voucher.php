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
$username = $_SESSION['username'];
$voucher_id = $_POST['voucher_id'];

$check = $conn->prepare("SELECT * FROM user_voucher WHERE username = ? AND voucher_id = ?");

$check->bind_param("si", $username, $voucher_id);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
$stmt = $conn->prepare("
    INSERT INTO user_voucher (username, voucher_id)
    VALUES (?, ?)
");
$stmt->bind_param("si", $username, $voucher_id);
$stmt->execute();

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
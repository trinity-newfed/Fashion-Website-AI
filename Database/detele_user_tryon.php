<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

session_start();

if(isset($_POST['id']) && isset($_SESSION['username'])) {
    $stmt = $conn->prepare("DELETE FROM tryon WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $_POST['id'], $_SESSION['username']);
    $stmt->execute();

if($stmt->execute()){
    header("Location: ../Pages/user.php");
    exit();
}else{
    echo "Delete Failed";
}

$stmt->close();
$conn->close();
}
header("Location: ../Pages/user.php");
exit();
?>
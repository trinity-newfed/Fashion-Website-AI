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

$userID = $_SESSION['user_id'];
$agree = $_POST['policy_id'];

$data = $conn->prepare("SELECT 1 FROM user_policy_agreement
                        WHERE id = ? AND policy_id = ?");
$data->bind_param("is", $userID, $agree);
$data->execute();
$check = $data->get_result();

if($check->num_rows == 0){
    $sql = $conn->prepare("INSERT INTO user_policy_agreement (user_id, policy_id) 
                       VALUES(?, ?)");
    $sql->bind_param("is", $userID, $agree);
    $sql->execute();
    $sql->close();
}

$data->close();
$conn->close();

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
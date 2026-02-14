<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "RS_Database";


$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("error" .$conn->connect_error);
}

$name = $_POST['name'];
$img = $_POST['img'];
$mail = $_POST['email'];
$address = $_POST['address'];
$hotline = $_POST['hotline'];
$rate = $_POST['rating'];

$data = "INSERT INTO employeedata(`name`,`img`,`email`,`address`,`hotline`,`rating`) VALUES('$name','$img','$mail','$address','$hotline','$rate')";

if($conn->query($data)){
    echo "<script>alert('Thêm $name thành công')</script>";
}
header("Location: admin.php");
    exit();
?>
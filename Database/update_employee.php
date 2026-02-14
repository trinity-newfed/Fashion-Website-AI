<?php
$conn = new mysqli("localhost", "root", "", "RS_Database");
if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

$id      = $_POST['id'];
$name    = $_POST['name'];
$email   = $_POST['email'];
$address = $_POST['address'];
$hotline = $_POST['hotline'];
$rating  = $_POST['rating'];

$sql = "UPDATE employeedata SET
            name    = '$name',
            email   = '$email',
            address = '$address',
            hotline = '$hotline',
            rating  = '$rating'
        WHERE id = $id";

if ($conn->query($sql)) {
    header("Location: admin.php");
    exit();
} else {
    echo "Lỗi: " . $conn->error;
}

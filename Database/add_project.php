<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "RS_Database";


$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("error" .$conn->connect_error);
}

$name = $_POST['product_name'];
$price = $_POST['product_price'];
$type = $_POST['product_type'];
$state = $_POST['product_state'];
$address = $_POST['product_address'];
$describe = $_POST['product_describe'];
$size = $_POST['product_size'];
$image = $_POST['product_img'];
$image1 = $_POST['product_img1'];
$image2 = $_POST['product_img2'];
$image3 = $_POST['product_img3'];

$data = "INSERT INTO products(`product_name`,`product_price`,`product_type`,`product_state`,`product_address`,`product_describe`,`product_size`,`product_img`,`product_img1`,`product_img2`,`product_img3`) VALUES('$name','$price','$type','$state','$address','$describe','$size','$image','$image1','$image2','$image3')";

if($conn->query($data)){
    echo "<script>alert('Thêm dữ liệu thành công <?=($name,$price,$type,$state,$address,$describe,$size,$image,$image1,$image2,$image3)?>'</script>";
}


?>
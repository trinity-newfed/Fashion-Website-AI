<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("error " . $conn->connect_error);
}

$name = $_POST['product_name'];
$price = $_POST['product_price'];
$type = $_POST['product_type'];
$state = $_POST['product_state'];
$describe = $_POST['product_describe'];
$size = $_POST['product_size'];

$uploadDir = __DIR__ . "/../picture-uploads/";

function uploadImage($file, $uploadDir) {
    if ($file['error'] === 0) {
        $fileName = time() . "_" . str_replace(" ", "-", $file['name']);
        $targetPath = $uploadDir . $fileName;
        move_uploaded_file($file['tmp_name'], $targetPath);
        return $fileName;
    }
    return null;
}

$image  = uploadImage($_FILES['product_img'], $uploadDir);
$image1 = uploadImage($_FILES['product_img1'], $uploadDir);
$image2 = uploadImage($_FILES['product_img2'], $uploadDir);
$image3 = uploadImage($_FILES['product_img3'], $uploadDir);

$data = "INSERT INTO products(`product_name`,`product_price`,`product_type`,`product_describe`,`product_size`,`product_img`,`product_img1`,`product_img2`,`product_img3`) VALUES ('$name','$price','$type','$describe','$size','$image','$image1','$image2','$image3')";

if ($conn->query($data)) {
    echo "<script>alert('Thêm dữ liệu thành công');</script>";
}

header("Location: admin.php");
exit();
?>

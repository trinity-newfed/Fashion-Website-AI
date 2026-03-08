<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "TF_DATABASE";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$file = fopen("products.csv", "r");

while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

    $name = $data[0];
    $price = $data[1];
    $category = $data[2];
    $type = $data[3];
    $description = $data[4];
    $color = $data[5];
    $size = $data[6];
    $front = $data[7];
    $side = $data[8];
    $back = $data[9];

    $sql = "INSERT INTO products 
            (product_name, product_price, product_category, product_type, product_describe, product_color, product_size, product_img, product_img1, product_img2)
            VALUES 
            ('$name','$price','$category','$type', '$description','$color','$size','$front','$side','$back')";

    $conn->query($sql);
}

fclose($file);

echo "Import products successfully!";

$conn->close();
?>

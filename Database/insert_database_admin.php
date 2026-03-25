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
    $group = $data[1];
    $price = $data[2];
    $category = $data[3];
    $type = $data[4];
    $description = $data[5];
    $color = $data[6];
    $size = $data[7];
    $front = $data[8];
    $side = $data[9];
    $back = $data[10];

    $sql = "INSERT INTO products 
            (product_name, product_group, product_price, product_category, product_type, product_describe, product_color, product_size, product_img, product_img1, product_img2)
            VALUES 
            ('$name','$group','$price','$category','$type', '$description','$color','$size','$front','$side','$back')";

    $conn->query($sql);
}

fclose($file);

echo "Import products successfully!";

$conn->close();
?>

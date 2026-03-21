<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "TF_DATABASE";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$file = fopen("vouchers.csv", "r");

while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

    $discount = $data[0];
    $conditon = $data[1];
    $max = $data[2];
    $tier = $data[3];

    $sql = "INSERT INTO vouchers 
            (voucher_discount, voucher_condition, voucher_max, voucher_min_tier)
            VALUES 
            ('$discount','$conditon','$max','$tier')";

    $conn->query($sql);
}

fclose($file);

echo "Import products successfully!";

$conn->close();
?>

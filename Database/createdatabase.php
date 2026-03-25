<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password);

if($conn->connect_error){
    die("error" .$conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

if($conn->query($sql)){
    
}else{
    echo"<script>alert('Database khởi tạo thất bại')</script>";
}
$conn->select_db($dbname);

$conn->query("CREATE TABLE IF NOT EXISTS products(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100),
    product_group INT,
    product_price DECIMAL(10,2),
    product_category ENUM('collections','men','women','accesories'),
    product_type VARCHAR(255),
    product_describe VARCHAR(255),
    product_color VARCHAR(255),
    product_size VARCHAR(255),
    product_img VARCHAR(255),
    product_img1 VARCHAR(255),
    product_img2 VARCHAR(255),
    product_is_delete TINYINT(1) DEFAULT 0,
    product_state ENUM('active','inactive') DEFAULT 'active'
    )");
$conn->query("CREATE TABLE IF NOT EXISTS cart(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    product_category VARCHAR(100),
    product_color VARCHAR(100),
    cart_size ENUM('S','M','L','XL') DEFAULT 'S',
    product_id INT,
    quantity INT
    )");
$conn->query("CREATE TABLE IF NOT EXISTS orders(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    order_name VARCHAR(100),
    order_original_price DECIMAL(10,2),
    discount INT,
    order_final_price DECIMAL(10,2),
    order_state ENUM('success','cancel','delivery','delivered'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
$conn->query("CREATE TABLE IF NOT EXISTS order_items(
    id INT(10) AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(100),
    product_name VARCHAR(100),
    order_original_price DECIMAL(10,2),
    product_id INT,
    price DECIMAL(10,2),
    img VARCHAR(100),
    color VARCHAR(100),
    size VARCHAR(100),
    quantity INT(10)
    )");
$conn->query("CREATE TABLE IF NOT EXISTS userdata(
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(40) UNIQUE NOT NULL,
    img VARCHAR(255),
    user_password VARCHAR(255) NOT NULL,
    user_address VARCHAR(100),
    user_hotline VARCHAR(20),
    user_sex ENUM('Male','Female','Other'),
    user_tier ENUM('1','2','3','4') DEFAULT '1',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
$conn->query("CREATE TABLE IF NOT EXISTS vouchers(
    id INT AUTO_INCREMENT PRIMARY KEY,
    voucher_discount INT,
    voucher_condition INT,
    voucher_max INT,
    voucher_min_tier ENUM('1','2','3','4'),
    vouchcer_state ENUM('active','inactive') DEFAULT 'active',
    starts_date VARCHAR(255),
    end_date VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
$conn->query("CREATE TABLE IF NOT EXISTS user_voucher(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    voucher_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
$conn->query("CREATE TABLE IF NOT EXISTS used_voucher(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    voucher_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
$conn->query("CREATE TABLE IF NOT EXISTS tryon(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    cloth_path VARCHAR(255),
    result_img VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
?>
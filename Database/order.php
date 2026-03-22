<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("error " . $conn->connect_error);
}

if(!isset($_SESSION['checkout_cart_ids'])){
    echo "<script>alert('No items selected!');
                  window.location.href='../Pages/cart.php';
          </script>";
}

$username = $_SESSION['username'];
$usernameShort = strtoupper(substr($username, 0, 3));
$orderCode = $usernameShort . date('YmdHis');
$cart_ids = $_SESSION['checkout_cart_ids'] ?? [];
$orderstate = "success";

if (empty($cart_ids)) {
    echo "<script>alert('No items selected!');
                  window.location.href='../Pages/cart.php';
          </script>";
}

$placeholders = implode(',', array_fill(0, count($cart_ids), '?'));

$sql = "SELECT 
            cart.id,
            cart.product_id,
            products.product_name,
            products.product_price,
            products.product_img,
            cart.product_color,
            cart.cart_size,
            cart.quantity
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.id IN ($placeholders)
        AND cart.username = ?";

$stmt = $conn->prepare($sql);

$types = str_repeat('i', count($cart_ids)) . 's';
$params = array_merge($cart_ids, [$username]);

$stmt->bind_param($types, ...$params);
$stmt->execute();

$data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$total = 0;
foreach ($data as $item){
    $total += $item['product_price'] * $item['quantity'];
}

$voucher = $_SESSION['voucher_id'] ?? 0;
if($voucher > 0){
    $vsql = $conn->prepare("SELECT voucher_discount, voucher_max FROM vouchers WHERE id = ?");
    $vsql->bind_param("i", $voucher);
    $vsql->execute();
    $d = $vsql->get_result();
    $dis = $d->fetch_assoc();
    $discount = $dis['voucher_discount'] ?? 0;
    $voucher_max = $dis['voucher_max'] ?? 0;
    $discount_amount = min($total * ($discount / 100), $voucher_max ?? PHP_INT_MAX);
    $vsql->close();
}else{
    $discount_amount = 0;
}


$final_total = max(0, $total - $discount_amount);

$conn->begin_transaction();

try{
    $stmt = $conn->prepare("
        INSERT INTO orders(username, order_name, order_original_price, discount, order_final_price, order_state)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssddds", $username, $orderCode, $total, $discount_amount, $final_total, $orderstate);
    $stmt->execute();

    $order_id = $stmt->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("
        INSERT INTO order_items (
            order_id,
            product_id,
            product_name,
            price,
            img,
            color,
            size,
            quantity
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    foreach ($data as $item){
        $stmt->bind_param(
            "iisdsssi",
            $order_id,
            $item['product_id'],
            $item['product_name'],
            $item['product_price'],
            $item['product_img'],
            $item['product_color'],
            $item['cart_size'],
            $item['quantity']
        );
        $stmt->execute();
    }

    $stmt->close();

    $usql = $conn->prepare("INSERT INTO used_voucher(username, voucher_id) 
                            VALUES(?, ?)");
    $usql->bind_param("si", $username, $voucher);
    $usql->execute();
    $usql->close();

    $del = $conn->prepare("DELETE FROM cart WHERE id IN ($placeholders)");
    $del->bind_param(str_repeat('i', count($cart_ids)), ...$cart_ids);
    $del->execute();
    $del->close();

    $vDel = $conn->prepare("DELETE FROM user_voucher WHERE voucher_id = ? AND username = ?");
    $vDel->bind_param("is", $voucher, $username);
    $vDel->execute();
    $vDel->close();

    $conn->commit();
    unset($_SESSION['checkout_cart_ids']);
    header("Location: ../Pages/cart.php");
    exit;

} catch (Exception $e){
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

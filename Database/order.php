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
$agree = $_POST['policy_id'];
$username = $_SESSION['username'];

$policy = $conn->prepare("SELECT * FROM user_policy_agreement
                          WHERE username = ? AND policy_id = ?");
$policy->bind_param("ss", $username, $agree);
$policy->execute();
$userAgree = $policy->get_result();
if($userAgree->num_rows == 0){
    $sql = $conn->prepare("INSERT INTO user_policy_agreement (username, policy_id)
                           VALUES (?, ?)");
    $sql->bind_param("ss", $username, $agree);
    $sql->execute();
    $sql->close();
}
$policy->close();

$usernameShort = strtoupper(substr($username, 0, 3));
$orderCode = $usernameShort . date('YmdHis');
$cart_ids = $_SESSION['checkout_cart_ids'] ?? [];
$from = [106.5775, 10.8908];
$address = $conn->prepare("SELECT user_address FROM userdata
                           WHERE email = ?");
$address->bind_param("s", $username);
$address->execute();
$userAddress = $address->get_result();
if($userAddress->num_rows > 0){
    $row = $userAddress->fetch_assoc();
    $add = $row['user_address'];

    function getCoords($add){
    $url = "https://photon.komoot.io/api/?q=" . urlencode($add) . "&limit=1";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if(!empty($data['features'])){
        return $data['features'][0]['geometry']['coordinates'];
    }

    return null;
    }
}

$toCoords = getCoords($add);
$orderstate = "success";

if (empty($cart_ids)){
    echo "<script>alert('No items selected!');
                  window.location.href='../Pages/cart.php';
          </script>";
}

function getDistance($from, $toCoords){
    $url = "https://router.project-osrm.org/route/v1/driving/" 
            . $from[0] . "," . $from[1] . ";" 
            . $toCoords[0] . "," . $toCoords[1] 
            . "?overview=false";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if(isset($data['routes'][0]['distance'])){
        $distance = $data['routes'][0]['distance'] / 1000;
        return $distance;
    }
    return null;
}
function getShippingFee($km){
    if($km < 20){
        return 2;
    }else if($km < 100){
        return 5;
    }else if($km < 1000){
        return 15;
    }else{
        return 25;
    }
}

if($toCoords){
    $km = getDistance($from, $toCoords);
    $shipFee = getShippingFee($km);
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
$discount_amount = 0;
$ship_discount = 0;

if($voucher > 0){
    $vsql = $conn->prepare("SELECT voucher_discount, voucher_type, voucher_max, voucher_type FROM vouchers WHERE id = ?");
    $vsql->bind_param("i", $voucher);
    $vsql->execute();
    $result = $vsql->get_result();
    if($dis = $result->fetch_assoc()){
        $val = $dis['voucher_discount'] ?? 0;
        $is_ship_voucher = ($dis['voucher_type'] == "shipping");
        $voucher_max = $dis['voucher_max'] ?? PHP_INT_MAX;
        if($is_ship_voucher){
            $ship_discount = $val;
            $discount_amount = 0;
        }else{
            $discount_amount = min($total * ($val / 100), $voucher_max);
            $ship_discount = 0;
        }
    }
    $vsql->close();
}

$FREE_SHIP_THRESHOLD = 700;
if($total >= $FREE_SHIP_THRESHOLD){
    $shipFee = 0;
    $ship_discount = 0;
}
$final_ship_fee = max(0, $shipFee - $ship_discount);
$final_total = max(0, $total - $discount_amount + $final_ship_fee);

$conn->begin_transaction();

try{
    $stmt = $conn->prepare("
        INSERT INTO orders(username, order_name, order_original_price, order_delivery_fee, discount, order_final_price, order_state)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssdddds", $username, $orderCode, $total, $final_ship_fee, $discount_amount, $final_total, $orderstate);
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

    $stmt = $conn->prepare("SELECT 
                        COUNT(*) AS total_orders, 
                        SUM(order_final_price) AS total_spent 
                        FROM orders WHERE username = ?");

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderData = $result->fetch_assoc();
    $totalOrdersCount = $orderData['total_orders'];
    $totalSpent = $orderData['total_spent'];

    $newTier = '1';

    if($totalOrdersCount >= 40 && $totalSpent >= 2500 || $totalSpent >= 5000 && $totalOrdersCount >= 1){
        $newTier = '4';
    }elseif($totalOrdersCount >= 25 && $totalSpent >= 1000 || $totalSpent >= 2000 && $totalOrdersCount >= 1){
        $newTier = '3';
    } elseif($totalOrdersCount >= 10 && $totalSpent >= 200 || $totalSpent >= 500 && $totalOrdersCount >= 1){
        $newTier = '2';
    }

    if($newTier !== '1'){
        $tierUpdate = $conn->prepare("UPDATE userdata SET user_tier = ? WHERE email = ?");
        $tierUpdate->bind_param("ss", $newTier, $username);
        $tierUpdate->execute();
        $tierUpdate->close();
    }
    $conn->commit();
    unset($_SESSION['checkout_cart_ids']);
    header("Location: ../Pages/cart.php");
    exit;

} catch (Exception $e){
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
session_start();
if(!isset($_SESSION['username'])){
  header("Location: reglog.php");
  exit();
}
$username = $_SESSION['username'];
$cart_ids = $_SESSION['checkout_cart_ids'];

$sql = "SELECT * FROM userdata
        WHERE email = ?";
$stmt = $conn->prepare($sql);
if(!$stmt){
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trinity Style - Payment</title>
    <link rel="icon" type="image/png" href="../Pictures/Banners/logo.png">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            background: url("../Pictures/Banners/payment-bg.png") no-repeat center center/cover;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .payment-box {
            background-color: #fff;
            width: 90%;
            max-width: 450px;
            max-height: 90vh;
            padding: 40px;
            border-radius: 2px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow-y: auto;
        }

        .payment-box p {
            opacity: 0.5;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 20px 0;
            user-select: none;
        }

        .payment-method {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .COD, .e-wallet {
            position: relative;
            display: flex;
            width: 100px;
            height: 100px;
            border: 1px solid #e0e0e0;
            background-color: #fff;
            transition: 0.3s;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .COD svg, .e-wallet svg {
            width: 40px;
            height: 40px;
        }

        input[type="radio"] {
            position: absolute;
            right: 8px;
            top: 8px;
            accent-color: #000;
            margin: 0;
        }

        .COD:hover, .e-wallet:hover {
            border-color: #000;
        }

        label:has(input:checked) {
            border: 1px solid #000;
        }

        .info-form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .input-group {
            position: relative;
            width: 100%;
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 1px solid #e0e0e0;
            outline: none;
            font-size: 14px;
            background: transparent;
            transition: 0.3s;
            box-sizing: border-box;
            appearance: none;
        }

        .input-group label {
            position: absolute;
            left: 0;
            top: 10px;
            font-size: 14px;
            color: #999;
            pointer-events: none;
            transition: 0.3s ease all;
        }

        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label,
        .input-group select:focus ~ label,
        .input-group select:not([value=""]):valid ~ label {
            top: -12px;
            font-size: 11px;
            color: #000;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .input-group input:focus, .input-group select:focus {
            border-bottom-color: #000;
        }

        .wallet-only {
            display: none;
            flex-direction: column;
            gap: 25px;
        }

        .btn-submit {
            margin-top: 20px;
            padding: 15px;
            background-color: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 12px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

    <div class="modal-overlay">
        <div class="payment-box">
            <p>Payment Method</p>
            <div class="payment-method">
                <label class="e-wallet">
                    <input type="radio" name="choose" id="pay-wallet" checked>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M440.3 96.9c-9.4-26.5-30.3-47.4-56.8-57-24.1-7.9-46.3-7.9-91.6-7.9L156 32c-44.8 0-67.2 0-91.3 7.5-26.5 9.6-47.4 30.5-57 57-7.7 24.3-7.7 46.7-7.7 91.7L0 323.8c0 45.2 0 67.4 7.5 91.5 9.6 26.5 30.5 47.4 57 57 24.3 7.7 46.7 7.7 91.6 7.7l135.7 0c45 0 67.4 0 91.6-7.7 26.5-9.6 47.4-30.5 57-57 7.7-24.3 7.7-46.7 7.7-91.5l0-135.5c0-45 0-67.4-7.7-91.5zM323.1 185.4l-25.8 21.1c-2.3 1.9-5.5 1.5-7.3-.9-13.2-16.2-33.7-25.4-56.1-25.4-25 0-40.6 10.9-40.6 26.2-.4 12.8 11.7 19.6 49.1 27.7 47.2 10 68.7 29.7 68.7 62.7 0 41.4-33.7 71.9-86.4 75.3l-5.1 24.5c-.4 2.3-2.6 4.1-5.1 4.1l-40.6 0c-3.4 0-5.8-3.2-5.1-6.4l6.4-27.3c-26-7.5-47.2-22-59.3-39.7-1.5-2.3-1.1-5.3 1.1-7l28.2-22c2.3-1.9 5.8-1.3 7.5 1.1 14.9 20.9 38 33.3 65.7 33.3 25 0 43.8-12.2 43.8-29.7 0-13.4-9.4-19.6-41.2-26.2-54.2-11.7-75.8-31.8-75.8-64.9 0-38.4 32.2-67.2 80.9-71l5.3-25.4c.4-2.3 2.6-4.1 5.1-4.1l39.9 0c3.2 0 5.8 3 5.1 6.2l-6.2 28.4c20.9 6.4 38 17.9 48.7 32.2 1.7 2.1 1.3 5.3-.9 7z"></path></svg>
                </label>
                <label class="COD">
                    <input type="radio" name="choose" id="pay-cod">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M64 32C28.7 32 0 60.7 0 96L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-192c0-35.3-28.7-64-64-64L72 128c-13.3 0-24-10.7-24-24S58.7 80 72 80l384 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L64 32zM416 256a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"></path></svg>
                </label>
            </div>

            <p>Information</p>
        <form action="../Database/order.php" method="POST">
            <div class="info-form">
                <div class="input-group">
                        <input type="text" id="name" value=<?=$username?> readonly>
                        <label for="name">Full Name</label> 
                </div>
                
                <div class="input-group">
                        <input type="text" id="phone" value="<?=$user['user_hotline']?>" readonly>
                        <label for="phone">Phone Number</label>
                </div>

                <div class="input-group">
                    <input type="text" id="address" value="<?=$user['user_address']?>" required>
                    <label for="address">Shipping Address</label>
                </div>

                <div id="wallet-field" class="wallet-only" style="display: flex;">
                    <div class="input-group">
                        <select id="bank" required>
                            <option value="" disabled="" selected="" hidden=""></option>
                            <option value="vcb">Vietcombank</option>
                            <option value="tcb">Techcombank</option>
                            <option value="bidv">BIDV</option>
                            <option value="vtb">VietinBank</option>
                            <option value="mbb">MB Bank</option>
                            <option value="acb">ACB</option>
                            <option value="vp">VPBank</option>
                            <option value="tp">TPBank</option>
                            <option value="sacom">Sacombank</option>
                            <option value="agri">Agribank</option>
                            <option value="hdb">HDBank</option>
                            <option value="vib">VIB</option>
                            <option value="shb">SHB</option>
                            <option value="ocb">OCB</option>
                            <option value="msb">MSB</option>
                            <option value="sea">SeABank</option>
                            <option value="scb">SCB</option>
                            <option value="exim">Eximbank</option>
                            <option value="lienviet">LPBank</option>
                            <option value="namabank">Nam A Bank</option>
                        </select>
                        <label for="bank">Select Bank</label>
                    </div>
                    <div class="input-group">
                        <input type="text" id="wallet-id" pattern="[0-9]{8,16}" maxlength="16" inputmode="numberic" required>
                        <label for="wallet-id">Account Number / ID</label>
                    </div>
                </div>
                <button class="btn-submit" type="submit">Confirm Order</button>
            </div>
        </form>
        </div>
    </div>

    <script>
        const walletField = document.getElementById("wallet-field");
        const radios = document.querySelectorAll('input[name="choose"]');

        radios.forEach((radio) => {
            radio.addEventListener("change", (e) => {
                if (e.target.id === "pay-wallet") {
                    walletField.style.display = "flex";
                    document.getElementById("bank").disabled = false;
                    document.getElementById("wallet-id").disabled = false;
                } else {
                    walletField.style.display = "none";
                    document.getElementById("bank").disabled = true;
                    document.getElementById("wallet-id").disabled = true;
                }
            });
        });
    </script>

</body></html>
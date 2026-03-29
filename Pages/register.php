<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['user_password'];
    $address  = trim($_POST['user_address'] ?? "");
    $sex      = $_POST["user_sex"] ?? "";
    $hotline  = trim($_POST['user_hotline']);
    $inputOtp = $_POST['registerOtp'] ?? '';

    if (empty($password) || strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters');window.history.back();</script>";
        exit;
    }

    // Check email tồn tại
    $stmt = $conn->prepare("SELECT id FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already exists!');window.history.back();</script>";
        exit;
    }

    if (empty($inputOtp)) {

        // Check spam OTP (30s)
        $stmt = $conn->prepare("SELECT created_at FROM user_otp WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (time() - strtotime($row['created_at']) < 30) {
                echo "<script>alert('Please wait 30s before requesting new OTP');window.location.href='reglog.php';</script>";
                exit;
            }
        }

        $otp = random_int(100000, 999999);
        $expire = time() + 180;

        $stmt = $conn->prepare("DELETE FROM user_otp WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $hashedOtp = password_hash($otp, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO user_otp (email, otp, expire_at) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $email, $hashedOtp, $expire);
        $stmt->execute();

        // Lưu tạm info user vào session
        $_SESSION['register_data'] = [
            'email' => $email,
            'password' => $password,
            'address' => $address,
            'sex' => $sex,
            'hotline' => $hotline
        ];
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('triple3tbusiness@gmail.com', 'Trinity Verify');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';

            $mail->Body = "
                <div style='font-family:Arial;padding:20px'>
                    <h2>Verification Code</h2>
                    <p>Hello, $email</p>
                    <p>Your OTP is:</p>
                    <h1 style='letter-spacing:5px'>$otp</h1>
                    <p>This code expires in 3 minutes.</p>
                </div>
            ";

            $mail->send();

            echo "<script>alert('OTP sent!');window.location.href='reglog.php';</script>";
            exit;

        } catch (Exception $e) {
            error_log($mail->ErrorInfo);
            echo "Send mail failed";
        }
    }
    else {

        if (!isset($_SESSION['register_data'])) {
            echo "<script>alert('Session expired');window.location.href='reglog.php';</script>";
            exit;
        }

        $stmt = $conn->prepare("SELECT otp, expire_at FROM user_otp WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            if (
                password_verify($inputOtp, $row['otp']) &&
                time() < $row['expire_at']
            ) {
                $data = $_SESSION['register_data'];
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

                $stmt = $conn->prepare("
                    INSERT INTO userdata 
                    (email, user_password, user_address, user_sex, user_hotline)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->bind_param(
                    "sssss",
                    $data['email'],
                    $hashedPassword,
                    $data['address'],
                    $data['sex'],
                    $data['hotline']
                );

                if ($stmt->execute()) {

                    $stmt = $conn->prepare("DELETE FROM user_otp WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();

                    unset($_SESSION['register_data']);

                    echo "<script>alert('Register success!');window.location.href='reglog.php';</script>";
                    exit;
                }

            } else {
                echo "<script>alert('Invalid or expired OTP');window.location.href='reglog.php';</script>";
            }

        } else {
            echo "<script>alert('OTP not found');window.location.href='reglog.php';</script>";
        }
    }
}
?>

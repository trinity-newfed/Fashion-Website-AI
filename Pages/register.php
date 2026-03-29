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

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $password = $_POST['user_password'] ?? "";
    $address = isset($_POST['user_address']) ? trim($_POST['user_address']) : "";
    $sex      = $_POST["user_sex"] ?? "";
    $hotline = isset($_POST['user_hotline']) ? trim($_POST['user_hotline']) : "";
    $inputOtp = $_POST['registerOtp'] ?? null;

    $stmt = $conn->prepare("SELECT id FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        echo "<script>alert('Email already exists!');window.history.back();</script>";
        exit;
    }

    if(empty($inputOtp)){

        $stmt = $conn->prepare("SELECT created_at FROM user_otp WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($row = $result->fetch_assoc()){
            if (time() - strtotime($row['created_at']) < 30){
                echo "<script>alert('Please wait 30s before requesting new OTP');window.location.href='reglog.php';</script>";
                exit;
            }
        }
        $stmt->close();

        $otp = random_int(100000, 999999);
        $expire = time() + 180;
        $hashedOtp = password_hash($otp, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("DELETE FROM user_otp WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO user_otp (email, otp, expire_at) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $email, $hashedOtp, $expire);
        $stmt->execute();

        $_SESSION['register_data'] = [
            'email' => $email,
            'password' => $password,
            'address' => $address,
            'sex' => $sex,
            'hotline' => $hotline
        ];

        $stmt->close();
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

            $mail->Body = '
                        <div style="margin:0; padding:0; background-color:#f2f2f2;">
                            <div style="max-width:480px; margin:40px auto; background:#ffffff; border-radius:8px; padding:32px; font-family:Arial, sans-serif; color:#202124; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                <div style="text-align:center; margin-bottom:24px;">
                                    <div style="font-size:20px; font-weight:500; color:#202124;">Verification Code</div>
                                </div>
                                <p style="font-size:14px; line-height:1.6; margin-bottom:20px;">
                                Hello, '.$email.'<br><br>
                                Please use the verification code below to sign in to your account.
                                </p>
                                <div style="text-align:center; margin:24px 0;">
                                    <span style="display:inline-block; font-size:28px; letter-spacing:6px; font-weight:bold; color:#202124; background:#f1f3f4; padding:12px 24px; border-radius:6px;">
                                        '.$otp.'
                                    </span>
                                </div>
                                <p style="font-size:13px; color:#5f6368; margin-bottom:20px;">
                                    This code will expire in 3 minutes. Do not share this code with anyone.
                                </p>    
                                <p style="font-size:12px; color:#9aa0a6;">
                                    If you didn’t request this, you can safely ignore this email.
                                </p>

                                </div>
                                <div style="text-align:center; font-size:11px; color:#9aa0a6; margin-top:12px;">© '.date("Y").' TRINITY STYLE AI</div>
                        </div>
                        ';

            $mail->send();

            echo "<script>alert('OTP sent!');window.location.href='reglog.php';</script>";
            exit;

        } catch (Exception $e) {
            error_log($mail->ErrorInfo);
            echo "Send mail failed";
        }
    }else{
        $data = $_SESSION['register_data'];

        $stmt = $conn->prepare("SELECT otp FROM user_otp WHERE email = ?");
        $stmt->bind_param("s", $data['email']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $userOtp = $row['otp'];

        if(!isset($_SESSION['register_data'])){
            echo "<script>
                    alert('Session expired, please register again');
                    window.location.href='reglog.php';
                  </script>";
            exit;
        }else{
            if($row){
                
            if(password_verify($inputOtp, $row['otp'])){
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
                    $stmt->bind_param("s", $data['email']);
                    $stmt->execute();

                    unset($_SESSION['register_data']);

                    echo "<script>
                            alert('Register success!');
                            window.location.href='reglog.php';
                          </script>";
                    exit;
                }

            } else {
                echo "<script>
                        alert('Invalid or expired OTP');
                        window.location.href='reglog.php';
                      </script>";
            }

        }else{
            echo "<script>
                    alert('OTP not found');
                    window.location.href='reglog.php';
                  </script>";
        }
        }
    }
}
?>

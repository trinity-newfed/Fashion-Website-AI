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

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $inputOtp = $_POST['registerOtp'] ?? '';
    $_SESSION['email']    = trim($_POST['email']);
    $_SESSION['password'] = $_POST['user_password'];
    $_SESSION['address']  = trim($_POST['user_address'] ?? null);
    $_SESSION['sex'] = $_POST["user_sex"] ?? "";
    $_SESSION['hotline']  = trim($_POST['user_hotline']);

    if(empty($_SESSION['password']) || strlen($_SESSION['password']) < 6){
        echo "<script>alert('Password must be at least 6 characters');window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        echo "<script>alert('Email already exists!');window.history.back();</script>";
        exit;
    }

    if(empty($inputOtp)){

        $otp = random_int(100000, 999999);
        $_SESSION['registerOtp'] = $otp;
        $_SESSION['otp_expire'] = time() + 180;

        try{
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('triple3tbusiness@gmail.com', 'Trinity Verify');
            $mail->addAddress($_SESSION['email']);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = '
                        <div style="margin:0; padding:0; background-color:#f2f2f2;">
                            <div style="max-width:480px; margin:40px auto; background:#ffffff; border-radius:8px; padding:32px; font-family:Arial, sans-serif; color:#202124; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                <div style="text-align:center; margin-bottom:24px;">
                                    <div style="font-size:20px; font-weight:500; color:#202124;">Verification Code</div>
                                </div>
                                <p style="font-size:14px; line-height:1.6; margin-bottom:20px;">
                                Hello, '.$_SESSION['email'].'<br><br>
                                Please use the verification code below to sign up your new account.
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

            echo "<script>
                    alert('OTP sent!');
                    window.location.href='reglog.php';
                  </script>";

        }catch(Exception $e){
            error_log($mail->ErrorInfo);
        }
    }

    elseif($inputOtp == $_SESSION['registerOtp']){


        $hashedPassword = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
        $email = $_SESSION['email'];
        $address = $_SESSION['address'];
        $sex = $_SESSION['sex'];
        $hotline = $_SESSION['hotline'];
        $stmt = $conn->prepare("
            INSERT INTO userdata 
            (email, user_password, user_address, user_sex, user_hotline)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssss", $email, $hashedPassword, $address, $sex, $hotline);
        if($stmt->execute()){
            unset($_SESSION['registerOtp']);
            unset($_SESSION['registerOtp']);
            unset($_SESSION['otp_expire']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            unset($_SESSION['address']);
            unset($_SESSION['sex']);
            unset($_SESSION['hotline']);

            echo "<script>
                    alert('Register success!');window.location='reglog.php';
                    window.location.href='reglog.php';
                  </script>";
            exit;
        }
    }
    else{
        unset($_SESSION['registerOtp']);
        unset($_SESSION['otp_expire']);
        echo "<script>
                alert('Invalid OTP');
                window.location.href='reglog.php';
              </script>";
    }
}
?>

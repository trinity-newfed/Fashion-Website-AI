<?php
session_set_cookie_params([
    'path' => '/',
]);
require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error){
    die("Lỗi kết nối " . $conn->connect_error);
}
$email = $_POST['username'];
$userpassword = $_POST['user_password'];

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $adminOtp = $_POST['otp'] ?? null;

    if($email === "Trung09" && $userpassword === "050509" || $email == "Tan1206" && $userpassword == "T@n77Dt"){
                $adminMail = "triple3tbusiness@gmail.com";
                if(!isset($_SESSION['admin_otp'])){
                    try{
                    $otp = rand(100000, 999999);
                    $_SESSION['admin_otp'] = $otp;
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $_ENV['SMTP_USER'];
                    $mail->Password = $_ENV['SMTP_PASS'];
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('triple3tbusiness@gmail.com', 'Trinity Admin Login Verify');
                    $mail->addAddress($adminMail);

                    $mail->isHTML(true);
                    $mail->Subject = 'Your Trinity OTP Code, Secure Your Account';
                    $mail->Body = '
                        <div style="margin:0; padding:0; background-color:#f2f2f2;">
                            <div style="max-width:480px; margin:40px auto; background:#ffffff; border-radius:8px; padding:32px; font-family:Arial, sans-serif; color:#202124; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                <div style="text-align:center; margin-bottom:24px;">
                                    <div style="font-size:20px; font-weight:500; color:#202124;">Verification Code</div>
                                </div>
                                <p style="font-size:14px; line-height:1.6; margin-bottom:20px;">
                                Hello, Admin<br><br>
                                Please use code below to verify your identity.
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
                                    This otp mail is for admin login only.
                                </p>

                                </div>
                                <div style="text-align:center; font-size:11px; color:#9aa0a6; margin-top:12px;">© '.date("Y").' TRINITY STYLE AI</div>
                        </div>
                        ';
                    $mail->send();
                }catch(Exception $e){
                    error_log("Mailer Error: " . $mail->ErrorInfo);
                }
                }
                if(isset($_SESSION['admin_otp']) && $_SESSION['admin_otp'] == $adminOtp){
                    unset($_SESSION['admin_otp']);
                    $_SESSION['role'] = "admin";
                    header("Location: ../Database/admin.php");
                    exit;
                }
    }

    $stmt = $conn->prepare("SELECT * FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if(isset($_SESSION['otp'])){
        $inputOtp = $_POST['otp'] ?? '';
        if(time() > $_SESSION['otp_expire']){
            unset($_SESSION['otp'], $_SESSION['otp_expire'], $_SESSION['otp_email']);
            echo "<script>alert('OTP expired!'); window.location.href='reglog.php';</script>";
            exit;
        }elseif($inputOtp == $_SESSION['otp']){
            if($result->num_rows > 0){
                $rows = $result->fetch_assoc();
                $_SESSION['username'] = $email;
                $_SESSION['user_id'] = $rows['id'];
                $_SESSION['role'] = 'user';
            }

            $stmt = $conn->prepare("UPDATE userdata SET user_limit_password = 0 WHERE email = ?");
            $stmt->bind_param("s", $_SESSION['otp_email']);
            $stmt->execute();
            $stmt->close();

            unset($_SESSION['otp'], $_SESSION['otp_expire'], $_SESSION['otp_email']);
            header("Location: ../Pages/");
            exit;
        }else{
            echo "<script>alert('Wrong OTP!'); window.location.href='reglog.php';</script>";
            exit;
        }
    }
    $stmt->close();
    
    $stmt = $conn->prepare("SELECT * FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result && $result->num_rows === 1){
        $row = $result->fetch_assoc();
        $count = $row['user_limit_password'];
        $hashedPassword = $row['user_password'];

        if(password_verify($userpassword, $hashedPassword)){
            if($count < 5){
                sleep(2);
                session_regenerate_id(true);
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['email'];
                $_SESSION['role'] = 'user';

                $stmt = $conn->prepare("UPDATE userdata SET user_limit_password = 0 WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->close();

                header("Location: ../Pages/");
                exit;
            }else{
                $_SESSION['otp_expire'] = time() + 180;
                $_SESSION['otp_email'] = $email;

                try{
                    $otp = rand(100000, 999999);
                    $_SESSION['otp'] = $otp;
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $_ENV['SMTP_USER'];
                    $mail->Password = $_ENV['SMTP_PASS'];
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('triple3tbusiness@gmail.com', 'Trinity Authentication');
                    $mail->addAddress($row['email']);

                    $mail->isHTML(true);
                    $mail->Subject = 'Your Trinity OTP Code, Secure Your Account';
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
                } catch(Exception $e){
                    error_log("Mailer Error: " . $mail->ErrorInfo);
                }

                echo "<script>alert('Too many login attempts! Check your email for OTP.'); window.location.href='reglog.php';</script>";
                exit;
            }

        }else{
            $count++;
            $sql = $conn->prepare("UPDATE userdata SET user_limit_password = ? WHERE email = ?");
            $sql->bind_param("is", $count, $email);
            $sql->execute();
            $sql->close();

            if($count >=5){
                sleep(rand(3, 5));
                echo "<script>
                        alert('Wrong password too many times! OTP required'); 
                        window.location.href='reglog.php';
                      </script>";
            }else{
                sleep(rand(3, 5));
                echo "<script>
                        alert('Wrong username or password!'); 
                        window.location.href='reglog.php';
                      </script>";
            }
        }

    }elseif(!isset($_SESSION['admin_otp'])){
        echo "<script>alert('Account not found!'); window.location.href='reglog.php';</script>";
    }elseif(isset($_SESSION['admin_otp'])){
        echo "<script>alert('Verify admin account by OTP!'); window.location.href='reglog.php';</script>";
    }
}
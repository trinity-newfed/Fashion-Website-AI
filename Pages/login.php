<?php
session_set_cookie_params(['path' => '/']);

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

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $email = $_POST['username'];
    $userpassword = $_POST['user_password'];
    $adminOtp = $_POST['otp'] ?? null;
    $inputOtp = $_POST['otp'] ?? null;

    if(
        ($email === "Trung09" && $userpassword === "050509") ||
        ($email === "Tan1206" && $userpassword === "T@n77Dt")
    ){

        $adminMail = "triple3tbusiness@gmail.com";

        if(
            !isset($_SESSION['admin_otp']) ||
            time() > ($_SESSION['admin_otp_expire'] ?? 0)
        ){
            try{
                $otp = rand(100000, 999999);
                $_SESSION['admin_otp'] = $otp;
                $_SESSION['admin_otp_expire'] = time() + 180;

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
                $mail->Subject = 'Your Trinity OTP Code';

                $mail->Body = "<h2>Your OTP: $otp</h2><p>Expires in 3 minutes</p>";

                $mail->send();

            }catch(Exception $e){
                error_log("Mailer Error: " . $mail->ErrorInfo);
            }
        }

        if(
            isset($_SESSION['admin_otp']) &&
            $adminOtp &&
            $_SESSION['admin_otp'] == $adminOtp &&
            time() < $_SESSION['admin_otp_expire']
        ){
            unset($_SESSION['admin_otp'], $_SESSION['admin_otp_expire']);
            session_regenerate_id(true);

            $_SESSION['role'] = "admin";
            header("Location: ../Database/admin.php");
            exit;
        }

        echo "<script>alert('Verify admin account by OTP!'); window.location.href='reglog.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if(!$result || $result->num_rows !== 1){
        echo "<script>alert('Account not found!'); window.location.href='reglog.php';</script>";
        exit;
    }

    $row = $result->fetch_assoc();
    $count = $row['user_limit_password'];
    $hashedPassword = $row['user_password'];

    if(isset($_SESSION['otp'])){

        if(time() > $_SESSION['otp_expire']){
            unset($_SESSION['otp'], $_SESSION['otp_expire'], $_SESSION['otp_email']);
            echo "<script>alert('OTP expired!'); window.location.href='reglog.php';</script>";
            exit;
        }

        if(
            $inputOtp &&
            $inputOtp == $_SESSION['otp'] &&
            $_SESSION['otp_email'] == $email
        ){
            session_regenerate_id(true);

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $email;
            $_SESSION['role'] = 'user';

            $stmt = $conn->prepare("UPDATE userdata SET user_limit_password = 0 WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            unset($_SESSION['otp'], $_SESSION['otp_expire'], $_SESSION['otp_email']);

            header("Location: ../Pages/");
            exit;

        }else{
            echo "<script>alert('Wrong OTP!'); window.location.href='reglog.php';</script>";
            exit;
        }
    }

    if(password_verify($userpassword, $hashedPassword)){

        if($count < 5){
            sleep(2);
            session_regenerate_id(true);

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $email;
            $_SESSION['role'] = 'user';

            $stmt = $conn->prepare("UPDATE userdata SET user_limit_password = 0 WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            header("Location: ../Pages/");
            exit;
        }
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
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "<h2>Your OTP: $otp</h2>";

            $mail->send();

        } catch(Exception $e){
            error_log("Mailer Error: " . $mail->ErrorInfo);
        }

        echo "<script>alert('Too many login attempts! Check your email for OTP.'); window.location.href='reglog.php';</script>";
        exit;

    }else{
        $count++;

        $stmt = $conn->prepare("UPDATE userdata SET user_limit_password = ? WHERE email = ?");
        $stmt->bind_param("is", $count, $email);
        $stmt->execute();

        sleep(rand(2,4));

        if($count >= 5){
            echo "<script>alert('Too many wrong attempts! OTP required.'); window.location.href='reglog.php';</script>";
        }else{
            echo "<script>alert('Wrong username or password!'); window.location.href='reglog.php';</script>";
        }
    }
}
?>

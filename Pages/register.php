<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "RS_Database";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $img    = trim($_POST['img']);
    $email    = trim($_POST['email']);
    $password = $_POST['user_password'];
    $address  = trim($_POST['user_address']);
    $hotline  = trim($_POST['user_hotline']);

    $password = $_POST['user_password'];

    if (empty($password)) {
    echo "<script>
            alert('Mật khẩu không được để trống!');
            window.history.back();
          </script>";
    exit;
    }

    if (strlen($password) < 6) {
    echo "<script>
            alert('Mật khẩu phải có ít nhất 6 ký tự!');
            window.history.back();
          </script>";
    exit;
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "SELECT id FROM userdata WHERE username = ? OR email = ?"
    );
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>
                alert('Tài khoản hoặc email đã tồn tại!');
                window.history.back();
              </script>";
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO userdata 
        (username, img, email, user_password, user_address, user_hotline)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssssss",
        $username,
        $img,
        $email,
        $hashedPassword,
        $address,
        $hotline
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Đăng ký thành công!');
                window.location.href = 'log.php';
              </script>";
        exit;
    } else {
        echo "<script>alert('Đăng ký thất bại!');</script>";
    }
}
?>

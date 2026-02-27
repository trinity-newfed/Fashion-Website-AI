<?php
session_set_cookie_params([
    'path' => '/',
]);
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Lỗi kết nối " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST['username'] ?? '';
    $userpassword = $_POST['user_password'] ?? '';

    if ($username === "Admin" && $userpassword === "Operationer") {
        $_SESSION['username'] = "Admin";
        $_SESSION['role'] = "admin";
        header("Location: ../Database/admin.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM userdata WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();


        $hashedPassword = $row['user_password'];


        if (password_verify($userpassword, $hashedPassword)) {
            $_SESSION['img'] = $row['img'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = 'user';

            header("Location: home.php");
            exit;
        }
    }
    
    echo "
    <script>
    alert('Wrong username or password!');
    window.location.href='log.php';
    </script>
    ";
}

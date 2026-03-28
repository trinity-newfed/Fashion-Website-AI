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

    $email = $_POST['username'] ?? '';
    $userpassword = $_POST['user_password'] ?? '';

    if ($email === "Tan1206" && $userpassword === "T@n77Dt"){
        $_SESSION['username'] = "[Admin]: Tân";
        $_SESSION['role'] = "admin";
        header("Location: ../Database/admin.php");
        exit;
    }else if($email === "Trung09" && $userpassword === "050509"){
         $_SESSION['username'] = "[Admin]: Trung";
        $_SESSION['role'] = "admin";
        header("Location: ../Database/admin.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();


        $hashedPassword = $row['user_password'];


        if (password_verify($userpassword, $hashedPassword)) {
            $_SESSION['username'] = $row['email'];
            $_SESSION['role'] = 'user';

            header("Location: home.php");
            exit;
        }
    }
    
    echo "
    <script>
    alert('Wrong username or password!');
    window.location.href='reglog.php';
    </script>
    ";
}

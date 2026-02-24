<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);

if (isset($_POST['submit']) && isset($_FILES['img'])) {

    $file = $_FILES['img'];

    $fileName  = $file['name'];
    $fileTmp   = $file['tmp_name'];
    $fileSize  = $file['size'];
    $fileError = $file['error'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($fileExt, $allowed)) {
        echo "
        <script>
        alert('File not image!');
        window.location.href='log.php';
        </script>
        ";
    }

    if ($fileSize > 5 * 1024 * 1024) {
        echo "
        <script>
        alert('File too large!');
        window.location.href='log.php';
        </script>
        ";
    }

    if ($fileError === 0) {

        $newFileName = uniqid("img_", true) . "." . $fileExt;
        $uploadPath = "../upload/" . $newFileName;

        if (move_uploaded_file($fileTmp, $uploadPath)) {

            $_SESSION['avatar_temp'] = $newFileName;

            header("Location: ../Pages/reg.php?avatar=1");
            exit;
        }
    }
}
?>

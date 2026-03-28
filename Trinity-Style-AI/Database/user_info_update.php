<?php 
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";
$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("error" .$conn->connect_error);
}

session_start();

$username = $_SESSION['username'];

$uploadDirAbsolute = __DIR__ . "/../upload/";
if (!is_dir($uploadDirAbsolute)) {
    mkdir($uploadDirAbsolute, 0777, true);
}
$fileName = basename($_FILES["img"]["name"]);
$newFileAbsolute = $uploadDirAbsolute . $fileName;
$newFileRelative = "upload/" . $fileName;
$imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowedTypes = ["jpg", "jpeg", "png", "gif"];

$res_current = $conn->query("SELECT * FROM userdata WHERE email = '$username'");
$current_data = $res_current->fetch_assoc();

$sex = !empty($_POST['user_sex']) ? $_POST['user_sex'] : $current_data['user_sex'];
$hotline = !empty($_POST['user_hotline']) ? $_POST['user_hotline'] : $current_data['user_hotline'];
$address = !empty($_POST['user_address']) ? $_POST['user_address'] : $current_data['user_address'];

if(!empty($_FILES['img']['name'])){
    if(in_array($imageFileType, $allowedTypes)){
        if(move_uploaded_file($_FILES["img"]["tmp_name"], $newFileAbsolute)){
            $result = $conn->query("SELECT img FROM userdata WHERE email = '$username'");
            if(!empty($result)){
                if($result && $row = $result->fetch_assoc()){
                    $oldImage = $row['img'];
                    if($oldImage && file_exists($oldImage)){
                        unlink($oldImage);
                    }
                }
            }

            $sql = $conn->prepare("UPDATE userdata SET
                                user_sex = ?,
                                user_hotline = ?,
                                user_address = ?,
                                img = ?
                                WHERE email = ?");
            $sql->bind_param("sssss", $sex, $hotline, $address, $newFileRelative, $username);
            $sql->execute();
            $sql->close();

        }else{
            echo "<script>
                    alert('Something wrong when upload new image!');
                  </script>";
        }
}else{
    echo "<script>
            alert('On accept jpg, jpeg, png, gif image type!');
          </script>";
}
}else{
    $newFile = null;
    $sql = $conn->prepare("UPDATE userdata SET
                                user_sex = ?,
                                user_hotline = ?,
                                user_address = ?
                                WHERE email = ?");
            $sql->bind_param("ssss", $sex, $hotline, $address, $username);
            $sql->execute();
            $sql->close();
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>

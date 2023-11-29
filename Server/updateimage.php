<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_FILES['pic']['name'])){
    $img_name = $_FILES['pic']['name'];
    $img_size = $_FILES['pic']['size'];
    $tmp_name = $_FILES['pic']['tmp_name'];
    $error = $_FILES['pic']['error'];

    if($error==0)
    {
        $img_ex = pathinfo($img_name,PATHINFO_EXTENSION);
        $img_ex_to_lc = strtolower($img_ex);

        $allowed_exs = array('jpg','jpeg','png');
        if(in_array($img_ex_to_lc,$allowed_exs)){
            $new_img_name = uniqid($_POST["email"], true).'.'.$img_ex_to_lc;
            $img_upload_path = '../upload/'.$new_img_name;
            move_uploaded_file($tmp_name,$img_upload_path);
        }else{
            die("Img File Extension Error");
        }
    }
}

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "UPDATE users SET avatar = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $new_img_name, $user_id);
$result = $stmt->execute();

if ($result) {
    header("Location: ../profile.php");
    exit();
} else {
    echo "Update failed!";
}

$stmt->close();
$mysqli->close();
?>
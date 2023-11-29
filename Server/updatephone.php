<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ( preg_match("/[a-z]/i", $_POST["phone"])) {
    die("Phone Number Must Be All Digits .");
}

if ( ! preg_match("/[0-9]/", $_POST["phone"])) {
    die("Phone Number Must Contain Digits .");
}
if (strlen($_POST["phone"]) < 8) {
    die("Phone Number Can't Be Less Than 8 Digits Long .");
}

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "UPDATE users SET phone = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $_POST['phone'], $user_id);
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
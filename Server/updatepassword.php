<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("si", $_POST['password'], $user_id);
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
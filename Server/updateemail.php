<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT COUNT(*) AS count FROM users WHERE email = ?";
    
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $_POST["email"]);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    $is_email_exists = true;
}

$stmt->close();

if (!$is_email_exists)
{
    $sql = "UPDATE users SET email = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("si", $_POST['email'], $user_id);
    $result = $stmt->execute();
}else{
    die("Email Address Already Taken .");
}

if ($result) {
    header("Location: ../profile.php");
    exit();
} else {
    echo "Update failed!";
}

$stmt->close();
$mysqli->close();
?>
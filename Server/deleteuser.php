<?php

session_start();

if (!isset($_SESSION['user_id'])){
    header("Location: sign-in.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {

    session_destroy();

    header("Location: ../index.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

header("Location: ../index.php");

exit;
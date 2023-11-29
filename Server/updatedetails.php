<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "UPDATE users SET name = ?,surname = ?,cin = ?, status=? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssisi", $_POST['name'], $_POST['surname'],$_POST['cin'], $_POST['accountstatus'], $user_id);
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
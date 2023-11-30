<?php

$mysqli = require __DIR__ . "/database.php";

$token = $_GET["token"];

// Check if the token exists in the database
$sql = "SELECT email FROM password_reset WHERE token = '$token'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Token is valid, allow the user to reset their password
    $row = $result->fetch_assoc();
    $email = $row["email"];

    // You can add a form here for the user to reset their password
    echo "<p>Token is valid for email: $email</p>";

    // You might want to add a form here for the user to reset their password
} else {
    // Token is invalid or expired
    echo "<p>Invalid or expired token</p>";
}

$conn->close();
?>
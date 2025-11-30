<?php
require "../config/db.php";

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO Users (userName, email, password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../pages/login.php?success=1");
} else {
    header("Location: ../pages/register.php?error=Username or Email already exists");
}
?>

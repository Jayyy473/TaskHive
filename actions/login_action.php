<?php
session_start();
require "../config/db.php";

$user = $_POST['username'];
$pass = $_POST['password'];

$query = "SELECT * FROM Users WHERE userName = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($pass, $row['password'])) {
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['username'] = $row['userName'];
        header("Location: ../pages/dashboard.php");
        exit();
    }
}

header("Location: ../pages/login.php?error=Invalid credentials");
exit();
?>
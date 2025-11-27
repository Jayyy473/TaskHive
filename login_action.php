<?php
require_once "db.php";
require_once "csrf.php";
session_start();

# Validate CSRF token
if (!csrf_verify($_POST['csrf_token'] ?? '')) {
    die("Invalid CSRF token.");
}

$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

# Validate fields
if ($email === "" || $password === "") {
    header("Location: login.php?error=Email and password are required");
    exit;
}

# Look up user
$sql = "SELECT userID, userName, password FROM Users WHERE email=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $row['password'])) {

        // Success — create session
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['username'] = $row['userName'];

        header("Location: home.php");
        exit;
    }
}

# If login fails
header("Location: login.php?error=Invalid email or password");
exit;
?>

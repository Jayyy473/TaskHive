<?php
require_once "db.php";
require_once "csrf.php";
session_start();

# Validate CSRF
if (!csrf_verify($_POST['csrf_token'] ?? '')) {
    die("Invalid CSRF token.");
}

# Collect fields
$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

# Basic validation
if ($username === "" || $email === "" || $password === "") {
    header("Location: register.php?error=All fields are required");
    exit;
}

# Check existing username/email
$query = "SELECT userID FROM Users WHERE userName=? OR email=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $username, $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    header("Location: register.php?error=Username or email already exists");
    exit;
}

# Insert user
$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO Users (userName, email, password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed);

if (mysqli_stmt_execute($stmt)) {
    # Auto-login user
    $_SESSION['userID'] = mysqli_insert_id($conn);
    $_SESSION['username'] = $username;

    header("Location: home.php");
    exit;
}

header("Location: register.php?error=Could not create account");
exit;
?>

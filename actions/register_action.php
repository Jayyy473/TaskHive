<?php
require "../config/db.php";

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Check if username or email already exists
$check = $link->prepare("SELECT userID FROM Users WHERE userName = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Store a message in the session so register.php can display it
    session_start();
    $_SESSION['register_error'] = "<div class='error-message'><strong>Username or Email already exists. Redirecting to log in instead...</strong></div>";
    header("Location: ../pages/register.php");
    exit;
}

// Insert new user
$stmt = $conn->prepare("INSERT INTO Users (userName, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
    header("Location: ../pages/login.php?success=1");
    exit;
} else {
    session_start();
    $_SESSION['register_error'] = "Registration failed. Try again.";
    header("Location: ../pages/register.php");
    exit;
}
?>

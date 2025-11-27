<?php
require_once "db.php";
require_once "csrf.php";
session_start();

if (empty($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

if (!csrf_verify($_POST['csrf_token'] ?? '')) die("Invalid CSRF");

$text = trim($_POST['taskText'] ?? '');
$priority = trim($_POST['priority'] ?? 'Normal');

if ($text === "") {
    header("Location: home.php?error=Task cannot be empty");
    exit;
}

$sql = "INSERT INTO Tasks (userID, taskText, priority) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iss", $_SESSION['userID'], $text, $priority);
mysqli_stmt_execute($stmt);

header("Location: home.php");
exit;
?>

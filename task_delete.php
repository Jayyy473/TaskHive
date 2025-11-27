<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$taskID = intval($_GET['id']);
$userID = $_SESSION['userID'];

// Secure delete
$stmt = $conn->prepare("DELETE FROM Tasks WHERE taskID = ? AND userID = ?");
$stmt->bind_param("ii", $taskID, $userID);
$stmt->execute();

header("Location: dashboard.php?msg=task_deleted");
exit();
?>

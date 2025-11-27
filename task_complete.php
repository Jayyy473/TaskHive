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

$stmt = $conn->prepare("UPDATE Tasks SET completed='Completed' WHERE taskID=? AND userID=?");
$stmt->bind_param("ii", $taskID, $userID);
$stmt->execute();

$log = $conn->prepare("INSERT INTO Task_Completions (taskID) VALUES (?)");
$log->bind_param("i", $taskID);
$log->execute();

header("Location: dashboard.php?msg=completed");
exit();
?>

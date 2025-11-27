<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$taskID = intval($_POST['taskID']);
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$category = $_POST['category'];
$dueDate = $_POST['dueDate'];
$completed = $_POST['completed'];

$stmt = $conn->prepare("
    UPDATE Tasks 
    SET title=?, description=?, priority=?, category=?, dueDate=?, completed=? 
    WHERE taskID=? AND userID=?
");

$stmt->bind_param(
    "ssssssii", 
    $title, 
    $description, 
    $priority, 
    $category, 
    $dueDate, 
    $completed, 
    $taskID, 
    $_SESSION['userID']
);

$stmt->execute();

header("Location: dashboard.php?msg=updated");
exit();
?>

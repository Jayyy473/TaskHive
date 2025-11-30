<?php
session_start();
require "../config/db.php";

$userID = $_SESSION['userID'];
$title = $_POST['title'];
$desc = $_POST['description'];
$priority = $_POST['priority'];
$due = $_POST['dueDate'];

$stmt = mysqli_prepare($conn, 
    "INSERT INTO Tasks (userID, title, description, priority, dueDate)
    VALUES (?,?,?,?,?)");

mysqli_stmt_bind_param($stmt, "issss",
    $userID, $title, $desc, $priority, $due
);

mysqli_stmt_execute($stmt);

header("Location: ../pages/dashboard.php");
exit();
?>
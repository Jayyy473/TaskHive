<?php
require "../config/db.php";

$id = $_POST['taskID'];
$title = $_POST['title'];
$desc = $_POST['description'];
$status = $_POST['completed'];
$due = $_POST['dueDate'];

$stmt = mysqli_prepare($conn,
    "UPDATE Tasks SET title=?, description=?, completed=?, dueDate=? WHERE taskID=?");

mysqli_stmt_bind_param($stmt, "ssssi",
    $title, $desc, $status, $due, $id
);

mysqli_stmt_execute($stmt);

header("Location: ../pages/dashboard.php");
exit();
?>
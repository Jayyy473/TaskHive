<?php
session_start();
require "../config/db.php";

$newName = $_POST['newName'];
$id = $_SESSION['userID'];

$stmt = mysqli_prepare($conn, "UPDATE Users SET userName=? WHERE userID=?");
mysqli_stmt_bind_param($stmt, "si", $newName, $id);
mysqli_stmt_execute($stmt);

$_SESSION['username'] = $newName;

header("Location: ../pages/settings.php");
exit();
?>
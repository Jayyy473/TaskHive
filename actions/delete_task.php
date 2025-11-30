<?php
require "../config/db.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM Tasks WHERE taskID=$id");
header("Location: ../pages/dashboard.php");
exit();
?>
<?php
session_start();
require_once "config/db.php";

$userID = $_SESSION['userID'];

$year = $_GET['year'];
$month = $_GET['month'];

$start = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
$end = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-31";

$sql = "SELECT taskID, title, priority, dueDate 
        FROM Tasks 
        WHERE userID = ? 
        AND dueDate BETWEEN ? AND ?
        ORDER BY dueDate ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $userID, $start, $end);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode($tasks);
?>

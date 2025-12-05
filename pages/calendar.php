<?php
session_start();
if (!isset($_SESSION['userID'])) header("Location: login.php");
require "../config/db.php";
$userID = $_SESSION['userID'];

$tasks = mysqli_query($conn, "SELECT * FROM Tasks WHERE userID=$userID AND dueDate IS NOT NULL");
$events = [];
while ($row = mysqli_fetch_assoc($tasks)) {
    $events[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Calendar | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
</head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="glass calendar-card" style="margin:90px;"> 
    <div class="header">
        <button id="prev" class="nav-btn">◀ Prev</button>
        <h2 id="monthLabel"></h2>
        <button id="next" class="nav-btn">Next ▶</button>
    </div>

    <div id="calendar"></div>
</div>

<script>
let events = <?= json_encode($events); ?>;
</script>
<script src="../assets/js/calendar.js"></script>

</body>
</html>

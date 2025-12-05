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
    <style>
    #calendar {
        /* Default for mobile: 4 columns */
        width: 100%;
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Changed from 7 to 4 columns for mobile */
        gap: 12px; /* Reduced gap for mobile density */
        margin-top: 20px;
    }
    .day {
        /* Reduced padding for mobile density */
        padding: 15px 5px; 
        border-radius: 15px; /* Slightly reduced radius */
        backdrop-filter: blur(12px);
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        cursor: pointer;
        transition: .3s;
        text-align:center;
        font-size: 16px; /* Reduced font size */
        font-weight: 600; /* Added weight for readability */
        aspect-ratio: 1 / 1; /* Makes the box square, improving presentation */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .day:hover {
        background: rgba(0, 47, 255, 0.75);
    }
    .hasEvent {
        background: rgba(0,200,255,0.35);
        border: 1px solid rgba(0, 0, 0, 0.5);
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px; /* Added spacing */
    }
    .nav-btn {
        padding: 8px 16px; /* Reduced padding */
        cursor: pointer;
        border-radius: 12px;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
        font-size: 14px;
        font-weight: 600;
    }
</style>
</head>
<body class="calendar-page">

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

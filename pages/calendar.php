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
            width: 100%;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 15px;
            margin-top: 20px;
        }
        .day {
            padding: 20px;
            border-radius: 20px;
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            cursor: pointer;
            transition: .3s;
            text-align:center;
            font-size: 18px;
        }
        .day:hover {
            background: rgba(255,255,255,0.25);
        }
        .hasEvent {
            background: rgba(0,200,255,0.35);
            border: 1px solid rgba(0,200,255,0.5);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-btn {
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 15px;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="glass" style="width:90%;margin:40px auto;padding:20px;">
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

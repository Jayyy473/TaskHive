<?php
session_start();
if (!isset($_SESSION['userID'])) header("Location: login.php");

require "../config/db.php";

$date = $_GET['date'];
$userID = $_SESSION['userID'];

$res = mysqli_query($conn, "SELECT * FROM Tasks WHERE userID=$userID AND dueDate='$date'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Timeline | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
</head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="glass" style="width:70%;margin:40px auto;">
    <h2>Tasks on <?= $date ?></h2>

    <?php while ($row = mysqli_fetch_assoc($res)): ?>
        <div class="glass" style="margin:15px 0;">
            <h3><?= $row['title'] ?></h3>
            <p><?= $row['description'] ?></p>
            <p>Status: <?= $row['completed'] ?></p>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

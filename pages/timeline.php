<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

require "../config/db.php";

$date = $_GET['date'] ?? date("Y-m-d");
$userID = $_SESSION['userID'];

$query = $conn->prepare("SELECT * FROM Tasks WHERE userID = ? AND dueDate = ? ORDER BY priority DESC, created_at ASC");
$query->bind_param("is", $userID, $date);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Timeline | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
    <link rel="stylesheet" href="../assets/css/timeline.css">
</head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="timeline-wrapper glass">
    <div style="color:black;">
    <h2>Tasks for <span><?= htmlspecialchars($date); ?></span></h2>
    </div>
    <a href="calendar.php" class="back-btn">← Back to Calendar</a>

    <?php if ($result->num_rows === 0): ?>
        <div class="empty-block">
            <img src="../assets/images/empty.png" class="empty-img">
            <p>No tasks for this date.</p>
        </div>
    <?php else: ?>
        <div class="timeline-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="timeline-item" onclick="openTask(<?= $row['taskID']; ?>)">
                
                <div class="bullet <?= strtolower($row['priority']); ?>"></div>

                <div class="content">
                    <h3><?= htmlspecialchars($row['title']); ?></h3>
                    <p><?= htmlspecialchars($row['description']); ?></p>

                    <div class="tags">
                        <span class="tag priority-<?= strtolower($row['priority']); ?>">
                            <?= $row['priority']; ?>
                        </span>

                        <span class="tag status-<?= str_replace(' ', '-', strtolower($row['completed'])); ?>">
                            <?= $row['completed']; ?>
                        </span>
                    </div>
                </div>

            </div>
        <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<script src="../assets/js/timeline.js"></script>
</body>
</html>

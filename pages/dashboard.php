<?php
session_start();
if (!isset($_SESSION['userID'])) header("Location: login.php");
require "../config/db.php";
$userID = $_SESSION['userID'];

$tasks = mysqli_query($conn, "SELECT * FROM Tasks WHERE userID=$userID ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
</head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="glass" style="width:80%;margin:30px auto;padding:20px;">
    <h2>Hello, <?= $_SESSION['username'] ?> 👋</h2>
    <h3>Your Tasks</h3>

    <!-- Add Task -->
    <form action="../actions/add_task.php" method="POST">
        <input type="text" name="title" id="taskTitle" placeholder="Task title..." required>
        <div id="suggestionsBox"></div>

        <textarea name="description" placeholder="Description..."></textarea>

        <label>Priority</label>
        <select name="priority">
            <option>None</option>
            <option>Low</option>
            <option>Medium</option>
            <option>High</option>
        </select>

        <label>Due Date</label>
        <input type="date" name="dueDate">

        <button class="btn">Add Task</button>
    </form>

    <hr>

    <!-- TASK LIST -->
    <?php if (mysqli_num_rows($tasks) == 0): ?>
        <div style="text-align:center;">
            <img src="../assets/images/empty.png" width="300">
            <p>No tasks yet. Add one above!</p>
        </div>
    <?php else: ?>
        <?php while ($row = mysqli_fetch_assoc($tasks)): ?>
            <div class="glass" style="margin:15px 0;">
                <h3><?= $row['title'] ?></h3>
                <p><?= $row['description'] ?></p>
                <p><strong>Status:</strong> <?= $row['completed'] ?></p>

                <a class="btn" href="edit_task.php?id=<?= $row['taskID'] ?>">Edit</a>
                <a class="btn" href="../actions/delete_task.php?id=<?= $row['taskID'] ?>"
                   onclick="return confirm('Delete task?')">Delete</a>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

</div>

<script src="../assets/js/suggestions.js"></script>
</body>
</html>

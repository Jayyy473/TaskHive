<?php
session_start();
if (!isset($_SESSION['userID'])) header("Location: login.php");
require "../config/db.php";

$userID = $_SESSION['userID'];

/* -----------------------------
   SORTING SYSTEM
------------------------------ */
$sort = $_GET['sort'] ?? '';

$orderBy = "";

switch ($sort) {
    case "date_asc":
        $orderBy = "ORDER BY dueDate ASC";
        break;

    case "date_desc":
        $orderBy = "ORDER BY dueDate DESC";
        break;

    case "priority_high":
        $orderBy = "ORDER BY 
            CASE priority 
                WHEN 'High' THEN 1
                WHEN 'Medium' THEN 2
                WHEN 'Low' THEN 3
                ELSE 4
            END ASC";
        break;

    case "priority_low":
        $orderBy = "ORDER BY 
            CASE priority 
                WHEN 'None' THEN 1
                WHEN 'Low' THEN 2
                WHEN 'Medium' THEN 3
                ELSE 4
            END ASC";
        break;

    default:
        $orderBy = "ORDER BY created_at DESC";
}

$query = "SELECT * FROM Tasks WHERE userID=$userID $orderBy";
$tasks = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/glass.css">
    <script src="../assets/js/task_suggestions.js" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="glass" style="width:85%;margin:30px auto;padding:20px;">
    <h2>Hello, <?= $_SESSION['username'] ?> 👋</h2>
    <h3>Your Tasks</h3>

    <!-- Add Task -->
    <form action="../actions/add_task.php" method="POST" class="add-task-form">
        <div style="text-align:center;">
            <label>Task Title</label>
            <input type="text" class="title" name="title" id="taskTitle" placeholder="Task title..." required>

            <div id="suggestionsBox"></div>

            <br><br>

            <label>Description</label>
            <textarea name="description" placeholder="Description..." required></textarea>

            <br><br>

            <label>Priority</label>
            <select name="priority">
                <option>None</option>
                <option>Low</option>
                <option>Medium</option>
                <option>High</option>
            </select>

            <br><br>

            <label>Due Date</label>
            <input type="date" name="dueDate" required>

            <br><br><br>
            <button class="btn">Add Task</button>
        </div>
    </form>

    <hr>

    <!-- SORT DROPDOWN -->
    <form method="GET" style="text-align:center; margin-bottom:10px;">
        <select name="sort" onchange="this.form.submit()" 
            style="padding:10px; border-radius:10px; backdrop-filter:blur(15px); background-color: rgba(255, 255, 255, 0.3);">
            <option value="">Sort Tasks</option>

            <option value="date_asc"  <?= ($sort=='date_asc' ? 'selected' : '') ?>>
                Due Date ↑
            </option>

            <option value="date_desc" <?= ($sort=='date_desc' ? 'selected' : '') ?>>
                Due Date ↓
            </option>

            <option value="priority_high" <?= ($sort=='priority_high' ? 'selected' : '') ?>>
                Priority: High → Low
            </option>

            <option value="priority_low" <?= ($sort=='priority_low' ? 'selected' : '') ?>>
                Priority: Low → High
            </option>
        </select>
    </form>

<!-- TASK LIST -->
<?php if (mysqli_num_rows($tasks) == 0): ?>
    <div style="text-align:center;">
        <img src="../assets/images/empty.png" width="300">
        <p>No tasks yet. Add one above!</p>
    </div>
<?php else: ?>
    <div class="task-list">
    <?php while ($row = mysqli_fetch_assoc($tasks)): ?>
        
        <div class="task-card glass" style="margin-top: 20px; margin-bottom: 20px;">

            <!-- PRIORITY BULLET -->
            <div class="priority-bullet <?= strtolower($row['priority']); ?>"></div>

            <!-- CONTENT -->
            <div class="task-content">
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

            <!-- ACTIONS -->
            <div class="task-actions">
                <a class="btn" href="edit_task.php?id=<?= $row['taskID']; ?>">Edit</a>
                <a class="btn" href="../actions/delete_task.php?id=<?= $row['taskID']; ?>">Delete</a>
            </div>

        </div>

    <?php endwhile; ?>
    </div>
<?php endif; ?>
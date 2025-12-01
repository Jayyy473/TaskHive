<?php
session_start();
if (!isset($_SESSION['userID'])) header("Location: login.php");

require "../config/db.php";
$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM Tasks WHERE taskID=$id");
$task = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Task | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
</head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="glass" style="width:60%;margin:40px auto;">
    <h2>Edit Task</h2>

    <form action="../actions/update_task.php" method="POST" class="add-task-form">
        <div style="text-align:center;">
        <input type="hidden" name="taskID" value="<?= $task['taskID'] ?>">
        <label>Task Title</label>
        <input type="text" name="title" value="<?= $task['title'] ?>">
        <br><br>
        <label>Description</label>
        <textarea name="description"><?= $task['description'] ?></textarea>
        <br><br>
        <label>Priority</label>
        <select name="priority">
            <option <?= $task['priority']=='None'?'selected':'' ?>>None</option>
            <option <?= $task['priority']=='Low'?'selected':'' ?>>Low</option>
            <option <?= $task['priority']=='Medium'?'selected':'' ?>>Medium</option>
            <option <?= $task['priority']=='High'?'selected':'' ?>>High</option>
        </select>
        <br><br>
        <label>Status</label>
        <select name="completed">
            <option <?= $task['completed']=='Pending start'?'selected':'' ?>>Pending start</option>
            <option <?= $task['completed']=='Current'?'selected':'' ?>>Current</option>
            <option <?= $task['completed']=='Completed'?'selected':'' ?>>Completed</option>
        </select>
        <br><br>
        <label>Due Date</label>
        <input type="date" name="dueDate" value="<?= $task['dueDate'] ?>">
        <br><br>
        <button class="btn" type="submit">Save</button>
        </div>
    </form>

</div>

</body>
</html>

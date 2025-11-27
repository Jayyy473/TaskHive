<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$taskID = intval($_GET['id']);
$userID = $_SESSION['userID'];

$stmt = $conn->prepare("SELECT * FROM Tasks WHERE taskID = ? AND userID = ?");
$stmt->bind_param("ii", $taskID, $userID);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    header("Location: dashboard.php?msg=not_found");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task - TaskHive</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>

<div class="edit-box fadeIn">
    <h2>Edit Task</h2>

    <form action="task_update_action.php" method="POST">
        <input type="hidden" name="taskID" value="<?= $task['taskID']; ?>">

        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($task['title']); ?>" required>

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($task['description']); ?></textarea>

        <label>Priority</label>
        <select name="priority">
            <option <?= $task['priority']=='None'?'selected':'' ?>>None</option>
            <option <?= $task['priority']=='Low'?'selected':'' ?>>Low</option>
            <option <?= $task['priority']=='Medium'?'selected':'' ?>>Medium</option>
            <option <?= $task['priority']=='High'?'selected':'' ?>>High</option>
        </select>

        <label>Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($task['category']); ?>">

        <label>Due Date</label>
        <input type="date" name="dueDate" value="<?= $task['dueDate']; ?>">

        <label>Status</label>
        <select name="completed">
            <option <?= $task['completed']=='Pending start'?'selected':'' ?>>Pending start</option>
            <option <?= $task['completed']=='Current'?'selected':'' ?>>Current</option>
            <option <?= $task['completed']=='Completed'?'selected':'' ?>>Completed</option>
        </select>

        <button class="btn">Update Task</button>
    </form>
</div>

</body>
</html>

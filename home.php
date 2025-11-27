<?php
require_once "db.php";
require_once "csrf.php";

if (empty($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['userID'];

$query = "SELECT taskID, taskText, priority, createdAt FROM Tasks WHERE userID=? ORDER BY createdAt DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$tasks = mysqli_stmt_get_result($stmt);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard — TaskHive</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/main.js" defer></script>
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<?php include __DIR__ . "/inc/header.php"; ?>

<main>
  <div class="hero-card" style="max-width:900px;flex-direction:column;">

    <h1 class="h-title" style="font-size:40px;">Your Tasks</h1>
    <p class="h-sub">Add tasks, set priorities, manage your day.</p>

    <form action="task_add.php" method="POST" style="width:100%;max-width:600px;margin-bottom:25px;">
      <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">

      <div class="row">
        <input class="input" type="text" name="taskText" placeholder="New task..." required>
        <select class="input" name="priority">
          <option value="Normal">Normal</option>
          <option value="High">High</option>
          <option value="Low">Low</option>
        </select>
        <button class="btn-primary" type="submit">Add</button>
      </div>
    </form>

    <div style="width:100%;max-width:700px;">
      <?php while ($t = mysqli_fetch_assoc($tasks)): ?>
        <div style="background:var(--glass);padding:14px;border-radius:12px;margin-bottom:10px;backdrop-filter: blur(10px);">
          <div style="font-weight:600;"><?= htmlspecialchars($t['taskText']) ?></div>
          <div class="muted"><?= $t['priority'] ?> • <?= $t['createdAt'] ?></div>
        </div>
      <?php endwhile; ?>
    </div>

  </div>
</main>

<?php include __DIR__ . "/inc/footer.php"; ?>
</body>
</html>

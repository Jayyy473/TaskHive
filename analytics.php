<?php
require_once "db.php";
session_start();

if (empty($_SESSION['userID'])) {
  header("Location: login.php");
  exit;
}

$uid = $_SESSION['userID'];

$total = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM Tasks WHERE userID=$uid"))[0];
$high  = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM Tasks WHERE userID=$uid AND priority='High'"))[0];
$low   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM Tasks WHERE userID=$uid AND priority='Low'"))[0];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Analytics — TaskHive</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/main.js" defer></script>
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<?php include __DIR__ . "/inc/header.php"; ?>

<main>
<div class="hero-card" style="max-width:850px;flex-direction:column;">

<h1 class="h-title" style="font-size:40px;">Analytics</h1>
<p class="h-sub">A quick look at your productivity.</p>

<div class="row" style="gap:20px;margin-top:20px;">
  <div style="flex:1;background:var(--glass);padding:20px;border-radius:12px;text-align:center;">
    <div style="font-size:42px;font-weight:700;"><?= $total ?></div>
    <div class="muted">Total Tasks</div>
  </div>

  <div style="flex:1;background:var(--glass);padding:20px;border-radius:12px;text-align:center;">
    <div style="font-size:42px;font-weight:700;"><?= $high ?></div>
    <div class="muted">High Priority</div>
  </div>

  <div style="flex:1;background:var(--glass);padding:20px;border-radius:12px;text-align:center;">
    <div style="font-size:42px;font-weight:700;"><?= $low ?></div>
    <div class="muted">Low Priority</div>
  </div>
</div>

</div>
</main>

<?php include __DIR__ . "/inc/footer.php"; ?>
</body>
</html>

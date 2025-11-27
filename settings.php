<?php
require_once "db.php";
require_once "csrf.php";
session_start();

if (empty($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Settings — TaskHive</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/main.js" defer></script>
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<?php include __DIR__ . "/inc/header.php"; ?>

<main>
  <div class="hero-card" style="max-width:720px;flex-direction:column;">
    <h1 class="h-title" style="font-size:38px;">Settings</h1>
    <p class="h-sub">Manage profile and preferences.</p>

    <div style="width:100%;max-width:480px;">
      <div style="background:var(--glass);padding:18px;border-radius:12px;margin-bottom:15px;">
        <strong>Logged in as:</strong> <?= htmlspecialchars($username) ?>
      </div>

      <a href="logout.php" class="btn-primary" style="width:100%;display:block;text-align:center;">Logout</a>
    </div>

  </div>
</main>

<?php include __DIR__ . "/inc/footer.php"; ?>
</body>
</html>

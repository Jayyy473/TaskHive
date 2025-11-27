<?php
// welcome.php
require_once "db.php";
session_start(); // pages will call session_start() as needed
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>TaskHive — Welcome</title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="js/main.js" defer></script>
</head>
<body>

<?php include __DIR__ . '/inc/header.php'; ?>

<main>
  <div class="hero-card">
    <div class="hero-left">
      <h1 class="h-title">TaskHive</h1>
      <p class="h-sub">Smart task management for students & developers — recurring tasks, priorities, and helpful suggestions.</p>

      <form action="register.php" method="get" style="max-width:480px">
        <div style="margin-bottom:12px">
          <input class="input" type="text" placeholder="Try: Prepare Networking lab report" aria-label="example">
        </div>
        <div class="row" style="margin-bottom:12px">
          <button type="button" class="btn-primary" onclick="window.location.href='register.php'">Get started — Create account</button>
          <button type="button" class="btn-outline" onclick="window.location.href='login.php'">Or sign in</button>
        </div>
      </form>

    </div>

    <div class="hero-right center">
      <!-- Illustration: use your image here or place a placeholder svg -->
      <img class="hero-illustration" src="assets/hero-tasks.png" alt="Task illustration">
    </div>
  </div>
</main>

<?php include __DIR__ . '/inc/footer.php'; ?>

</body>
</html>
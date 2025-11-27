<?php
require_once "db.php";
require_once "csrf.php";
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Register — TaskHive</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/main.js" defer></script>
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>

<?php include __DIR__ . "/inc/header.php"; ?>

<main>
  <div class="hero-card" style="max-width:780px;">
    <div class="hero-left">
      <h1 class="h-title" style="font-size:38px;">Create your TaskHive Account</h1>
      <p class="h-sub">Join to start organizing tasks smarter and faster.</p>

      <?php if (!empty($_GET['error'])): ?>
        <div style="background:#ffd8d8;padding:12px;border-radius:10px;margin-bottom:15px;color:#7a0000;">
          <?= htmlspecialchars($_GET['error']) ?>
        </div>
      <?php endif; ?>

      <form action="register_action.php" method="POST" style="max-width:420px;">
        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">

        <div style="margin-bottom:12px;">
          <label>Username</label><br>
          <input class="input" type="text" name="username" required>
        </div>

        <div style="margin-bottom:12px;">
          <label>Email</label><br>
          <input class="input" type="email" name="email" required>
        </div>

        <div style="margin-bottom:18px;">
          <label>Password</label><br>
          <input class="input" type="password" name="password" required>
        </div>

        <div class="row">
          <button type="submit" class="btn-primary">Create Account</button>
          <button type="button" class="btn-outline" onclick="window.location.href='login.php'">Already have an account?</button>
        </div>
      </form>

    </div>
  </div>
</main>

<?php include __DIR__ . "/inc/footer.php"; ?>

</body>
</html>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
</head>
<body>

<div class="glass" style="width:450px;margin:120px auto;">
    <div style="text-align:center;">
    <h2>Welcome Back 👋</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color:lightgreen;">Account created successfully!</p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?=$_GET['error']?></p>
    <?php endif; ?>

    <form action="../actions/login_action.php" method="POST">
        <label>Username</label>
        <input required type="text" name="username">
        <br>
        <br>
        <label>Password</label>
        <input required type="password" name="password">
        <br>
        <br>
        <button class="btn" type="submit">Login</button>
    </form>

    <p>Don’t have an account? <a href="register.php">Register</a></p>
    </div>
</div>

</body>
</html>

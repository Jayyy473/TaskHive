<?php
session_start();
if (isset($_SESSION['register_error'])) {
    echo "<div class='error-message'>" . htmlspecialchars($_SESSION['register_error']) . "</div>";
    // Clear the message after showing it
    unset($_SESSION['register_error']);
    // Redirect to login after showing the message
    header("Refresh: 3; URL=login.php"); // waits 3 seconds then redirects
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
</head>
<body>

<div class="glass auth-card">
    
    <div style="text-align:center;">
    <h2>Create an Account</h2>

    <form action="../actions/register_action.php" method="POST">
        <label>Username</label>
        <input required type="text" name="username">
        <br>
        <br>
        <label>Email-Acc</label>
        <input required type="email" name="email">
        <br>
        <br>
        <label>Password</label>
        <input required type="password" name="password">
        <br>
        <br>
        <button class="btn register" type="submit">Register</button>
    </form>
    
    <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
</head>
<body>

<div class="glass" style="width:450px;margin:120px auto;">
    <h2>Create an Account</h2>

    <form action="../actions/register_action.php" method="POST">
        <label>Username</label>
        <input required type="text" name="username">

        <label>Email</label>
        <input required type="email" name="email">

        <label>Password</label>
        <input required type="password" name="password">

        <button class="btn" type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>

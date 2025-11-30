<?php
session_start();
if (!isset($_SESSION['userID'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings | TaskHive</title>
    <link rel="stylesheet" href="../assets/css/glass.css">
</head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="glass" style="width:40%;margin:40px auto;">
    <h2>Settings</h2>

    <form action="../actions/update_profile.php" method="POST">
        <label>Change Username</label>
        <input type="text" name="newName" value="<?= $_SESSION['username'] ?>" required>

        <button class="btn">Save</button>
    </form>
</div>

</body>
</html>

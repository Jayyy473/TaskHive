<?php
session_start();
// Redirects unauthorized users to the login page
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit(); // Always exit after a redirect
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings | TaskHive</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/glass.css">
    </head>
<body>

<?php include "../components/navbar.php"; ?>

<div class="glass settings-card">
    <div class="settings-content"> 
        
        <h2>Settings</h2>

        <?php if (isset($_SESSION['success_message'])): ?>
            <p style="color: green; font-weight: 600;"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <p style="color: red; font-weight: 600;"><?= htmlspecialchars($_SESSION['error_message']) ?></p>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <h3>Change Username</h3>
        <form action="../actions/update_profile.php" method="POST" class="settings-form">
            <label for="newName">Username</label>
            <input id="newName" type="text" name="newName" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>
            <button class="btn" type="submit" name="action" value="update_username">Save Username</button>
        </form>

        <hr style="width: 80%; margin: 30px auto; border-top: 1px solid rgba(0,0,0,0.2);">

        <h3>Danger Zone</h3>
        <div style="margin-top: 20px; text-align: center;">
            <p style="font-size: 14px; color: #a00;">Permanently delete your TaskHive account and all associated data.</p>
            <form action="../actions/update_profile.php" method="POST" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.');">
                <input type="hidden" name="action" value="delete_account">
                <button class="btn" type="submit" style="background: #ff5252cc; color: white; border: 1px solid red; font-weight: 700;">
                    Delete Account
                </button>
            </form>
            
        </div>
        
    </div>
</div>

</body>
</html>
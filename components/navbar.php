<?php if (!isset($_SESSION)) { session_start(); } ?>
<link rel="stylesheet" href="../assets/css/glass.css">

<div class="glass" style="padding:15px;display:flex;justify-content:space-between;">
    <strong>🐝 TaskHive</strong>

    <nav class ="nav-links">
        <strong>
        <a href="dashboard.php">Home</a> |
        <a href="calendar.php">Calendar</a> |
        <a href="settings.php">Settings</a> |
        <a href="../actions/logout.php">Logout</a>
        </strong>
    </nav>
</div>

<?php if (!isset($_SESSION)) { session_start(); } ?>
<link rel="stylesheet" href="../assets/css/glass.css">

<header class="navbar-wrapper">
    <div class="glass nav-glass">
        <strong class="brand-logo">🐝 TaskHive</strong>

        <nav class ="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="calendar.php">Calendar</a>
            <a href="settings.php">Settings</a>
            <a href="../actions/logout.php">Logout</a>
        </nav>
    </div>
</header>
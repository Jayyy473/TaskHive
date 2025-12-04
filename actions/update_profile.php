<?php
session_start();

// 1. SECURITY & CONFIGURATION CHECK
// Ensure user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: ../pages/login.php");
    exit();
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../pages/settings.php");
    exit();
}

// Requires the database connection and configuration
require "../config/db.php"; 

$userID = $_SESSION['userID'];
$action = $_POST['action'] ?? ''; // Get the action from the hidden input/button value

// -----------------------------------------------------
// ACTION 1: UPDATE USERNAME
// -----------------------------------------------------
if ($action === 'update_username') {
    $newName = trim($_POST['newName'] ?? '');

    if (empty($newName)) {
        $_SESSION['error_message'] = "Username cannot be empty.";
        header("Location: ../pages/settings.php");
        exit();
    }
    
    // Check if the new username already exists (Optional but recommended)
    $stmt_check = mysqli_prepare($conn, "SELECT userID FROM Users WHERE userName = ? AND userID != ?");
    mysqli_stmt_bind_param($stmt_check, "si", $newName, $userID);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);
    
    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        $_SESSION['error_message'] = "That username is already taken. Please choose another one.";
        header("Location: ../pages/settings.php");
        exit();
    }
    
    // Update the username in the database
    $stmt_update = mysqli_prepare($conn, "UPDATE Users SET userName = ? WHERE userID = ?");
    mysqli_stmt_bind_param($stmt_update, "si", $newName, $userID);

    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['username'] = $newName; // Update the session variable
        $_SESSION['success_message'] = "Username updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating username: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt_check);
    mysqli_stmt_close($stmt_update);
} 

// -----------------------------------------------------
// ACTION 2: UPDATE PASSWORD
// -----------------------------------------------------
elseif ($action === 'update_password') {
    $oldPassword = $_POST['oldPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Basic Validation
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error_message'] = "All password fields are required.";
        header("Location: ../pages/settings.php");
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error_message'] = "New password and confirmation password do not match.";
        header("Location: ../pages/settings.php");
        exit();
    }
    
    // 1. Retrieve the current hashed password from the database
    $stmt_fetch = mysqli_prepare($conn, "SELECT password FROM Users WHERE userID = ?");
    mysqli_stmt_bind_param($stmt_fetch, "i", $userID);
    mysqli_stmt_execute($stmt_fetch);
    mysqli_stmt_bind_result($stmt_fetch, $hashedPassword);
    mysqli_stmt_fetch($stmt_fetch);
    mysqli_stmt_close($stmt_fetch);

    // 2. Verify the old password
    if (!password_verify($oldPassword, $hashedPassword)) {
        $_SESSION['error_message'] = "Current password is incorrect.";
        header("Location: ../pages/settings.php");
        exit();
    }
    
    // 3. Hash the new password securely
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // 4. Update the password in the database
    $stmt_update = mysqli_prepare($conn, "UPDATE Users SET password = ? WHERE userID = ?");
    mysqli_stmt_bind_param($stmt_update, "si", $newHashedPassword, $userID);
    
    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['success_message'] = "Password updated successfully! You will need to log back in next time.";
        // Optional: Force a log out for immediate security: session_destroy(); header("Location: ../pages/login.php"); exit();
    } else {
        $_SESSION['error_message'] = "Error updating password: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt_update);
}

// -----------------------------------------------------
// ACTION 3: DELETE ACCOUNT
// -----------------------------------------------------
elseif ($action === 'delete_account') {
    // 1. You should normally require the user's password here for security,
    //    but for simplicity, we will skip that and rely on the logout.
    
    // Perform the deletion in the database
    $stmt_delete = mysqli_prepare($conn, "DELETE FROM Users WHERE userID = ?");
    mysqli_stmt_bind_param($stmt_delete, "i", $userID);
    
    if (mysqli_stmt_execute($stmt_delete)) {
        // Successful deletion
        mysqli_stmt_close($stmt_delete);
        
        // 2. Clear the session and redirect to the login page
        session_unset();
        session_destroy();
        
        // Use a GET parameter to show a general success message on the login page
        header("Location: ../pages/login.php?deleted=true");
        exit();
        
    } else {
        // Handle database error
        $_SESSION['error_message'] = "Error deleting account: " . mysqli_error($conn);
        mysqli_stmt_close($stmt_delete);
    }
} 

// Redirect back to settings page to display messages
header("Location: ../pages/settings.php");
exit();
?>
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
// ACTION 2: DELETE ACCOUNT
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
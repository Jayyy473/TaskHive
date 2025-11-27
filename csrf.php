<?php
// csrf.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Returns a CSRF token stored in session (creates one if missing)
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify the posted token against stored one
 */
function csrf_verify($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string)$token);
}
?>

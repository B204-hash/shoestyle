<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//  (role_id != 1)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login_admin.php");
    exit();
}

// Auto logout after 30 minutes of inactivity
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();    
    session_destroy();   
    header("Location: login_admin.php");
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();
?>

<?php
session_start();
require 'admin/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate client role and fetch email
$stmt = $pdo->prepare("SELECT user_id, role_id, email FROM users WHERE user_id = :user_id AND role_id = 0 LIMIT 1");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Invalid session or not a client
    session_unset();
    session_destroy();
    header("Location: login.php?error=invalid_session");
    exit();
}

if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = $user['email'];
}

?>

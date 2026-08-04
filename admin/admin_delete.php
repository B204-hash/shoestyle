<?php
require 'session.php';
require 'connection.php';

// Ensure the user_id is provided
if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    die("Valid User ID is required.");
}

$user_id = (int)$_GET['user_id'];
$current_user_id = $_SESSION['user_id'];

if ($user_id === $current_user_id) {
    die("You cannot delete your own admin account.");
}

try {
    $pdo->beginTransaction();

    // checks if the user exists and is an admin (role == 1)
    $check = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id AND role_id = 1");
    $check->execute([':user_id' => $user_id]);
    $admin = $check->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        throw new Exception("Admin user not found.");
    }

    // Proceed with deletation
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id AND role_id = 1");
    $stmt->execute([':user_id' => $user_id]);

    $pdo->commit();

    header("Location: admin_view.php?deleted=1");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . htmlspecialchars($e->getMessage()));
}

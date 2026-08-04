<?php
require_once 'session_client.php'; 
require_once 'admin/connection.php';

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error_message = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $error_message = "New password and confirm password do not match.";
    } elseif (strlen($newPassword) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    } else {
        try {
            // Fetch the current hashed password from DB
            $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE user_id = :user_id AND role_id = 0 LIMIT 1");
            $stmt->execute(['user_id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($currentPassword, $user['password_hash'])) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

                // Update new password
                $updateStmt = $pdo->prepare("UPDATE users SET password_hash = :newPassword, updated_at = NOW() WHERE user_id = :user_id");
                $updateStmt->execute([
                    'newPassword' => $newPasswordHash,
                    'user_id' => $user_id
                ]);

                $success_message = "Password changed successfully.";
            } else {
                $error_message = "Current password is incorrect.";
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php 
$page_title = "Change Password";
include 'includes/navbar.php';
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Client Change Password</h5>
        </div>
        <div class="card-body">
            <?php if ($error_message): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="alert alert-success text-center"><?= htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Current Password<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Enter your current password" required>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter your new password (min 8 characters)" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Re-enter your new password" required>
                </div>
                <button type="submit" class="btn btn-primary">Change</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
</body>
</html>

<?php
session_start();
require 'admin/connection.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // data validation
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $error = "An account with this email already exists.";
        } else {
            // Hash password for better security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert client with role_id = 0
            $insert = $pdo->prepare("INSERT INTO users (email, role_id, password_hash) VALUES (:email, 0, :password_hash)");
            $insert->execute([
                'email' => $email,
                'password_hash' => $hashedPassword
            ]);

            // Start session after registration
            $user_id = $pdo->lastInsertId();
            $_SESSION['user_id'] = $user_id;

            header("Location: main.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signup.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-sm w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4">Create an account</h2>
            <form id="signup-form" method="POST" action="">
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address<span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm-password" placeholder="Repeat your password" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Continue</button>
                <div class="mt-3 text-center">
                    <small>Already have an account? <a href="login.php" class="text-success">Login</a></small>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>



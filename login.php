<?php
session_start();
require 'admin/connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // check if fields are empty
    if (empty($email) || empty($password)) {
        $error = "Please fill in both fields.";
    } else {
        $stmt = $pdo->prepare("SELECT user_id, role_id, password_hash FROM users WHERE email = :email AND role_id = 0 LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // check if data is valid
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role_id'] = $user['role_id'];
            header("Location: main.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>

<body>
    <div class="card mx-auto mt-5 p-4" style="max-width: 400px;">
        <h2 class="text-center mb-4">Welcome back</h2>
        <form method="POST" action="login.php">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email address<span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Continue</button>
            <div class="mt-3 text-center">
                <small>Don't have an account? <a href="signup.php" class="text-success">Sign Up</a></small>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
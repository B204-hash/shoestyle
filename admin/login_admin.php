<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['login_attempts'] >= 10) {
        echo "<script>alert('Too many failed attempts. Try again later.');</script>";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND role_id = 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = true;
            $_SESSION['role_id'] = $user['role_id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['login_attempts']++;
            echo "<script>alert('Invalid username or password. Attempt " . $_SESSION['login_attempts'] . "/10');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="style_login.css" rel="stylesheet">


</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card shadow-lg">
            <div class="text-center mb-4">
                <i class="fas fa-user-shield login-icon"></i>
                <h4 class="mt-2">Admin Panel Login</h4>
            </div>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="username" 
                        name="username" 
                        placeholder="Enter your username" 
                        required 
                        <?= ($_SESSION['login_attempts'] >= 10) ? 'disabled' : '' ?>>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            name="password" 
                            placeholder="Enter your password" 
                            required 
                            <?= ($_SESSION['login_attempts'] >= 10) ? 'disabled' : '' ?>>
                        <span class="input-group-text" id="togglePassword"><i class="fas fa-eye"></i></span>
                    </div>
                </div>

                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

                <?php if ($_SESSION['login_attempts'] >= 10): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        Too many failed login attempts. Try again later.
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Bootstrap + FontAwesome JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            togglePassword.innerHTML = type === "password"
                ? '<i class="fas fa-eye"></i>'
                : '<i class="fas fa-eye-slash"></i>';
        });
    </script>
</body>
</html>

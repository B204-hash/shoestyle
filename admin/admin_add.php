<?php 
require_once 'session.php';
require 'connection.php';

try {
    if (!$pdo instanceof PDO) { // checkes if there is a db connection (using pdo)
        throw new Exception("Database connection not ensured.");
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username    = trim($_POST['username']);
        $full_name   = trim($_POST['full_name']);
        $password    = trim($_POST['password']);
        $email       = trim($_POST['email']);
        $phone       = trim($_POST['phone']);

        // validations
        if (empty($username) || empty($full_name) || empty($password) || empty($email) || empty($phone)) {
            $error = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } elseif (strlen($password) < 8) {
            $error = "Password must be at least 8 characters long.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $pdo->beginTransaction();
            try {
              // inserting params to db using query
                $stmt = $pdo->prepare("INSERT INTO users 
                    (username, full_name, password_hash, email, phone_number, role_id) 
                    VALUES 
                    (:username, :full_name, :password_hash, :email, :phone,  1)");
                $stmt->execute([
                    ':username' => $username,
                    ':full_name' => $full_name,
                    ':password_hash' => $hashed_password,
                    ':email' => $email,
                    ':phone' => $phone
                ]);
                $pdo->commit();
                $success = "Admin account created successfully.";
                $username = $full_name = $password = $email = $phone = '';
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "Error creating admin account: " . htmlspecialchars($e->getMessage());
            }
        }
    }
} catch (Exception $e) {
    die("Database connection error: " . htmlspecialchars($e->getMessage()));
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Admin Account</title>
  <!-- CSS & Styles-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

       <!-- Topbar Section -->
<div class="container-fluid bg-dark px-5 d-none d-lg-block topbar">
  <div class="row gx-0">
    <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
      <div class="d-inline-flex align-items-center" style="height: 45px;">
        <small class="me-3"><i class="fa fa-map-marker-alt me-2"></i>Admin Dashboard</small>
        <small class="me-3"><i class="fa fa-phone-alt me-2"></i>Step Up Style</small>
      </div>
    </div>
    <div class="col-lg-4 text-center text-lg-end">
      <div class="d-inline-flex align-items-center" style="height: 45px;">
        <div class="nav-item dropdown me-3">
          <a class="nav-link dropdown-toggle text-light" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="admin_password.php">Change Password</a></li>
            <li><a class="dropdown-item" href="admin_view.php">View Admin Profile</a></li>
            <li><a class="dropdown-item" href="admin_add.php">Add Admin</a></li>
          </ul>
        </div>
        <a class="btn btn-sm btn-outline-light" href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Navbar -->
<div class="container-fluid position-relative p-0">
  <nav class="navbar navbar-expand-lg navbar-dark px-4 px-lg-5 py-3 py-lg-0">
    <a href="dashboard.php" class="navbar-brand p-0">
      <h1 class="m-0"><i class="fa fa-map-marker-alt me-3"></i>Step Up Style</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="fa fa-bars text-light"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto py-0">
        <a href="dashboard.php" class="nav-item nav-link active">Home</a>
        <div class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Products</a>
          <div class="dropdown-menu dropdown-menu-end">
            <a href="product_view.php" class="dropdown-item">View Products</a>
            <a href="product_add.php" class="dropdown-item">Add Products</a>
          </div>
        </div>
        <a href="payment_view.php" class="nav-item nav-link">Payments</a>
        <a href="client_view.php" class="nav-item nav-link">Clients</a>
      </div>
    </div>
  </nav>
</div>


  <div class="container mt-5">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Add New Admin</h4>
      </div>
      <div class="card-body">




        <!-- Success & Error Messages -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
          <fieldset class="border p-3 rounded">
            <legend class="w-auto px-2">Admin Info</legend>

          <div class="mb-3">
            <div class="col-mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" class="form-control" id="username" name="username"
                value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
            </div>

            <div class="col-mb-3">
              <label for="full_name" class="form-label">Full Name:</label>
              <input type="text" class="form-control" id="full_name" name="full_name"
                value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>" required>
            </div>
          </div>

            <div class="mb-3">
              <div class="col-md-6">
              <label for="password" class="form-label">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="col-md-6">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" name="email"
                value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>
            </div>

            <div class="col-mb-3">
              <label for="phone" class="form-label">Phone:</label>
              <input type="text" class="form-control" id="phone" name="phone"
                value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" required>
            </div>
          </fieldset>

          <div class="mt-3 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
          </div>
        </form>
      </div>
    </div>
  </div>
        <!--footer section-->
  <footer class="footer bg-dark text-light pt-5 pb-3 mt-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
        <p class="mb-0">&copy; <span class="text-primary">Step Up Style</span>. All Rights Reserved.</p>
        <small>Designed by <a href="#" class="text-light text-decoration-underline">Brisild Velo</a></small>
      </div>
      <div class="col-md-6 text-center text-md-end">
        <ul class="footer-links list-inline mb-0">
          <li class="list-inline-item"><a href="dashboard.php" class="text-light">Home</a></li>
          <li class="list-inline-item"><a href="#" class="text-light">ToS</a></li>
          <li class="list-inline-item"><a href="#" class="text-light">Privacy</a></li>
          <li class="list-inline-item"><a href="#" class="text-light">FAQs</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

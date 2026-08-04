<?php
require 'session.php';
require 'connection.php';

if (!isset($_GET['user_id'])) {
    die("User ID is required.");
}

$user_id = (int)$_GET['user_id'];
$message = '';
$error = '';

try {
    // Fetch admin details
    $stmt = $pdo->prepare(
        "SELECT username, email, full_name, phone_number 
         FROM users 
         WHERE user_id = :user_id AND role_id = 1"
    );
    $stmt->execute(['user_id' => $user_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        $error = "Admin not found or not authorized.";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get updated values or fallback to existing
        $username   = !empty(trim($_POST['username']))      ? trim($_POST['username'])      : $admin['username'];
        $full_name  = !empty(trim($_POST['full_name']))     ? trim($_POST['full_name'])     : $admin['full_name'];
        $email      = !empty(trim($_POST['email']))         ? trim($_POST['email'])         : $admin['email'];
        $phone      = !empty(trim($_POST['phone_number']))  ? trim($_POST['phone_number'])  : $admin['phone_number'];

        $pdo->beginTransaction();

        $stmt_update = $pdo->prepare(
            "UPDATE users 
             SET username = :username, full_name = :full_name, email = :email, phone_number = :phone_number 
             WHERE user_id = :user_id AND role_id = 1"
        );
        $stmt_update->execute([
            'username'      => $username,
            'full_name'     => $full_name,
            'email'         => $email,
            'phone_number'  => $phone,
            'user_id'       => $user_id
        ]);

        $pdo->commit();
        $message = "Admin updated successfully.";

        // Refresh admin data
        $admin['username'] = $username;
        $admin['full_name'] = $full_name;
        $admin['email'] = $email;
        $admin['phone_number'] = $phone;
    }
} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $error = "Database error: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
  <!-- Topbar Section -->
<div class="container-fluid bg-dark px-5 d-none d-lg-block topbar">
  <div class="row gx-0">
    <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
      <div class="d-inline-flex align-items-center" style="height: 45px;">
        <small class="me-3">Admin Dashboard</small>
        <small class="me-3">Step Up Style</small>
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
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Edit Admin Account</h4>
        </div>
        <div class="card-body">

            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST" novalidate>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($admin['full_name']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" value="<?= htmlspecialchars($admin['phone_number']) ?>">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Update Admin</button>
                    <a href="admin_view.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
require_once 'session.php';
require_once 'connection.php';

// Fetch number of clients
$stmtClients = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role_id = 0");
$stmtClients->execute();
$totalClients = $stmtClients->fetchColumn();

// Fetch number of products
$stmtProducts = $pdo->prepare("SELECT COUNT(*) FROM products");
$stmtProducts->execute();
$totalProducts = $stmtProducts->fetchColumn();

// Fetch number of sales (count of payments)
$stmtSales = $pdo->prepare("SELECT COUNT(*) FROM payment_info");
$stmtSales->execute();
$totalSales = $stmtSales->fetchColumn();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:ital,wght@0,900;1,900&display=swap" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />


  <link href="style.css" rel="stylesheet"/>

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

  <!-- Admin Content Area -->
  <div class="container admin-content">
    <h2>Welcome to the Admin Dashboard</h2>
    <p>Manage your client-side from this centralized dashboard.</p>
    
    <!--  admin dashboard content -->

    <div class="row mt-4">
  <div class="col-md-4">
    <a href="client_view.php" class="text-decoration-none text-dark">
      <div class="stat-card text-center p-4 shadow-sm rounded">
        <div class="stat-icon mb-2"><i class="fas fa-users fa-2x"></i></div>
        <div class="stat-number h4"><?= $totalClients ?></div>
        <div class="stat-label">Total Clients</div>
      </div>
    </a>
  </div>
  
  <div class="col-md-4">
    <a href="product_view.php" class="text-decoration-none text-dark">
      <div class="stat-card text-center p-4 shadow-sm rounded">
        <div class="stat-icon mb-2"><i class="fas fa-boxes fa-2x"></i></div>
        <div class="stat-number h4"><?= $totalProducts ?></div>
        <div class="stat-label">Total Products</div>
      </div>
    </a>
  </div>

  <div class="col-md-4">
    <a href="payment_view.php" class="text-decoration-none text-dark">
      <div class="stat-card text-center p-4 shadow-sm rounded">
        <div class="stat-icon mb-2"><i class="fas fa-credit-card fa-2x"></i></div>
        <div class="stat-number h4"><?= $totalSales ?></div>
        <div class="stat-label">Total Sales</div>
      </div>
    </a>
  </div>
</div>



</div>


  <!--Footer -->
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


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
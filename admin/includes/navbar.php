<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
  .topbar {
    background-color: #212529;
    font-size: 14px;
    border-bottom: 1px solid #444;
  }

  .topbar small {
    color: #ddd;
  }

  .topbar a,
  .navbar a {
    color: #ddd !important;
  }

  .topbar .dropdown-menu,
  .navbar .dropdown-menu {
    background-color: #343a40;
    border: none;
  }

  .topbar .dropdown-item,
  .navbar .dropdown-item {
    color: #f8f9fa;
  }

  .topbar .dropdown-item:hover,
  .navbar .dropdown-item:hover {
    background-color: #495057;
  }

  .navbar {
    background-color: #343a40;
  }

  .navbar-brand h1 {
    font-size: 24px;
    color: #f8f9fa;
  }

  .navbar-nav .nav-link {
    color: #f8f9fa;
    margin-right: 15px;
    transition: 0.3s;
  }

  .navbar-nav .nav-link:hover,
  .navbar-nav .nav-link.active {
    color: #0d6efd !important;
  }

  .btn-outline-light {
    border-color: #ccc;
    color: #f8f9fa;
  }

  .btn-outline-light:hover {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
  }
</style>

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

<!-- Bootstrap JS (needed for dropdowns and responsive navbar) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

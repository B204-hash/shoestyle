

<!-- Topbar -->
 <link rel="stylesheet" href="css/styles.css">
<div class="container-fluid bg-dark text-white px-5 py-2 d-none d-lg-block">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <div class="d-inline-flex align-items-center gap-4">
        <small><i class="fa fa-map-marker-alt me-2"></i>123 Street, Tirana, Albania</small>
        <small><i class="fa fa-phone-alt me-2"></i>+355 69 63 15 227</small>
        <small><i class="fa fa-envelope-open me-2"></i>brisildvelo17@gmail.com</small>
      </div>
    </div>
    <div class="col-lg-4 text-end">
      <div class="d-inline-flex align-items-center gap-2">
        <a class="btn btn-sm btn-outline-light rounded-circle" href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
        <a class="btn btn-sm btn-outline-light rounded-circle" href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a class="btn btn-sm btn-outline-light rounded-circle" href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        <a class="btn btn-sm btn-outline-light rounded-circle" href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
        <a class="btn btn-sm btn-outline-light rounded-circle" href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
  </div>
</div>

<!-- Navbar -->
<div class="container-fluid position-relative p-0">
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 px-lg-5 py-3 py-lg-0">
    <a href="main.php" class="navbar-brand d-flex align-items-center">
      <h1 class="text-primary m-0"><i class="fa fa-map-marker-alt me-3"></i>Step Up Shoes</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="fa fa-bars"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto py-0">
        <a href="main.php" class="nav-item nav-link active">Home</a>
        <a href="products.php" class="nav-item nav-link">Products</a>
        <a href="about.php" class="nav-item nav-link">About Us</a>
        <a href="contact.php" class="nav-item nav-link">Contact</a>
      </div>

      <?php if (isset($_SESSION['user_id'], $_SESSION['role_id']) && $_SESSION['role_id'] == 0): ?>
        <div class="dropdown ms-3">
          <button class="btn btn-primary dropdown-toggle rounded-pill px-4 py-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            Client Menu
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="client_profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
            <li><a class="dropdown-item" href="purchase_history.php">Purchases</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
          </ul>
        </div>
      <?php else: ?>
        <a href="signup.php" class="btn btn-outline-primary rounded-pill px-4 py-2 ms-3">Register</a>
      <?php endif; ?>
    </div>
  </nav>
</div>

<!-- Hero Section -->
<div class="container-fluid py-5 mb-5 hero-header">
  <div class="container py-5">
    <div class="row justify-content-center text-center text-white">
      <div class="col-lg-10 pt-lg-5 mt-lg-5">
        <h1 class="display-3 animated slideInDown"><?php echo $page_title; ?></h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="main.php" class="text-white text-decoration-underline">Home</a></li>
            <li class="breadcrumb-item text-white active" aria-current="page"><?php echo $page_title; ?></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<?php session_start();
include 'admin/connection.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stylish Shoes</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:ital,wght@0,900;1,900&display=swap" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Custom Styles -->
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body>

    <!--topbar section-->
    <?php 
    $page_title = "Products";
    include 'includes/navbar.php'?>
    
<!--product section-->

<div class="container text-center my-5">
  <h1 class="mb-4 display-5 fw-bold text-dark">Choose a Category</h1>
  <div class="row justify-content-center g-4">
    
    <!-- Men's Shoes -->
    <div class="col-lg-4 col-md-6">
      <div class="card border-0 shadow-lg h-100 category-card">
        <img src="images/men_shoes.jpg" class="card-img-top rounded-top" alt="Men Shoes">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title fw-semibold">Men's Shoes</h5>
          <p class="card-text text-muted mb-4">Explore our collection of stylish and durable men's shoes.</p>
          <a href="men_shoes.php" class="btn btn-outline-primary mt-auto">View Products</a>
        </div>
      </div>
    </div>

    <!-- Women's Shoes -->
    <div class="col-lg-4 col-md-6">
      <div class="card border-0 shadow-lg h-100 category-card">
        <img src="images/women_shoes.jpg" class="card-img-top rounded-top" alt="Women Shoes">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title fw-semibold">Women's Shoes</h5>
          <p class="card-text text-muted mb-4">Browse elegant and comfortable shoes for every occasion.</p>
          <a href="women_shoes.php" class="btn btn-outline-danger mt-auto">View Products</a>
        </div>
      </div>
    </div>

  </div>
</div>


  <!-- Footer -->
   <?php include 'includes/footer.php'?>
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();
 include 'admin/connection.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Step Up Shoes</title>

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
    $page_title = "Homepage";
    include 'includes/navbar.php'?>

    <!--product section-->
    
<div class="container my-5">
  <div class="row g-4 justify-content-center">
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




  
  <!-- about us section -->

<!-- About Us Section -->
<div class="container-xxl py-5">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
        <div class="position-relative h-100">
          <img class="img-fluid position-absolute w-100 h-100" src="images/about.jpg" alt="About Us" style="object-fit: cover;">
        </div>
      </div>
      <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
        <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
        <h1 class="mb-4">Welcome to <span class="text-primary">Step Up Shoes</span></h1>
        <p class="mb-4">At Stylish Shoes, we bring style and comfort together with our curated selection of high-quality footwear. Our goal is to help you step out in confidence—whether you’re hitting the streets or dressing to impress.</p>
        <p class="mb-4">With years of industry experience, we’re passionate about fashion-forward designs, durable materials, and providing a seamless shopping experience from start to finish. Discover the perfect pair for every occasion, only at Aleks Shoes.</p>
        <div class="row gy-2 gx-4 mb-4">
          <div class="col-sm-6"><p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Top Quality Footwear</p></div>
          <div class="col-sm-6"><p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Latest Trends & Styles</p></div>
          <div class="col-sm-6"><p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Comfort-First Design</p></div>
          <div class="col-sm-6"><p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Free & Fast Delivery</p></div>
          <div class="col-sm-6"><p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Exclusive Collections</p></div>
          <div class="col-sm-6"><p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>24/7 Customer Support</p></div>
        </div>
        <a href="about.php" class="btn btn-primary py-3 px-5 mt-2">Read More</a>
      </div>
    </div>
  </div>
</div>


  <!-- Contact Us Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center g-4">
      <!-- Contact Info -->
      <div class="col-lg-5 col-md-6">
        <h5 class="mb-3">Get In Touch</h5>
        <p>We’d love to hear from you! Feel free to reach out for any inquiries, assistance, or feedback.</p>

        <div class="d-flex align-items-start mb-3">
          <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <p class="mb-0">123 Street, Tirana, Albania</p>
        </div>

        <div class="d-flex align-items-start mb-3">
          <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
            <i class="fas fa-phone-alt"></i>
          </div>
          <p class="mb-0">+355 69 63 15 227</p>
        </div>

        <div class="d-flex align-items-start">
          <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
            <i class="fas fa-envelope-open"></i>
          </div>
          <p class="mb-0">brisildvelo17@gmail.com</p>
        </div>
      </div>

      <!-- Google Maps -->
      <div class="col-lg-5 col-md-6">
        <div class="ratio ratio-4x3 rounded shadow-sm overflow-hidden">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2995.731466404921!2d19.815017200000003!3d41.336452300000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x135031f8eaaf6d61%3A0xe8ae86116298b1a3!2sTirana%20ICT%20Academy%20-%20CompTIA%2C%20CISCO%2C%20CCNA!5e0!3m2!1sen!2s!4v1753807180731!5m2!1sen!2s" 
            style="border:0;" allowfullscreen="" loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Footer -->
   <?php include 'includes/footer.php'?>
   
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

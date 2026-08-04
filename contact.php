<?php session_start();
include_once 'admin/connection.php'?>

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
  <link rel="stylesheet" href="css/contact.css" />
</head>

<body>

    <!--topbar section-->
    <?php 
    $page_title = "Contact Us";
    include 'includes/navbar.php'?>

<!--product section-->


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
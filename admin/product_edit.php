<?php
require 'session.php';
require 'connection.php';

if (!isset($_GET['product_id'])) {
    die("Product ID is required.");
}

$product_id = (int)$_GET['product_id'];
$message = "";

// Fetch current product data
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
$stmt->execute(['product_id' => $product_id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['package_name'] ?? '';
    $description = $_POST['package_description'] ?? '';
    $price = $_POST['price_per_person'] ?? 0;
    $category = $_POST['packageType'] ?? '';
    
    $imagePath = $product['image']; 

    if (!empty($_FILES['package_image']['name'])) {
        $imageName = basename($_FILES['package_image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . time() . "_" . $imageName;
        move_uploaded_file($_FILES['package_image']['tmp_name'], $targetFile);
        $imagePath = $targetFile;
    }

    try { //update products with new parameters
        $updateStmt = $pdo->prepare("
            UPDATE products SET 
                product_name = :product_name,
                description = :description,
                price = :price,
                category = :category,
                image = :image
            WHERE product_id = :product_id
        ");

        $updateStmt->execute([
            ':product_name' => $product_name,
            ':description' => $description,
            ':price' => $price,
            ':category' => $category,
            ':image' => $imagePath,
            ':product_id' => $product_id
        ]);

        $message = "<div class='alert alert-success'>Product updated successfully.</div>";
        // Refresh the product data after update
        $stmt->execute(['product_id' => $product_id]);
        $product = $stmt->fetch();
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Error updating product: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <h3>Edit Product</h3>
        </div>
        <div class="card-body">
            <?= $message ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="col-md-6 mb-3">
                    <label for="package_name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="package_name" name="package_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="package_description" class="form-label">Description</label>
                    <textarea class="form-control" id="package_description" name="package_description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price_per_person" class="form-label">Price ($)</label>
                    <input type="number" class="form-control" id="price_per_person" name="price_per_person" value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="packageType" class="form-label">Product Category</label>
                    <select class="form-select" id="packageType" name="packageType" required>
                        <option value="men" <?= $product['category'] == 'men' ? 'selected' : '' ?>>Men</option>
                        <option value="women" <?= $product['category'] == 'women' ? 'selected' : '' ?>>Women</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="package_image" class="form-label">Product Image</label><br>
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>" width="100" class="mb-2"><br>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="package_image" name="package_image">
                    <small class="form-text text-muted">Leave blank to keep current image.</small>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="product_view.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

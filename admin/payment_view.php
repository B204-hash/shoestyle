<?php 
require 'session.php';
require 'connection.php';

// Fetch all purchases with product, user, and payment details
$stmt = $pdo->prepare("
    SELECT 
        p.purchase_id,
        pr.product_name,
        u.full_name,
        u.email,
        u.phone_number,
        p.quantity,
        p.unit_price,
        pi.final_price,
        pi.payment_method,
        pi.payment_date
    FROM purchases p
    INNER JOIN products pr ON p.product_id = pr.product_id
    INNER JOIN payment_info pi ON p.payment_id = pi.payment_id
    INNER JOIN card_details cd ON pi.card_id = cd.card_id
    INNER JOIN users u ON cd.user_id = u.user_id
    ORDER BY pi.payment_date DESC
");
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Purchases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css
    ">
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
        <div class="card-body">
            <div class="table-responsive">
                <table id="purchaseTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price ($)</th>
                            <th>Total Price ($)</th>
                            <th>Payment Method</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($purchases): ?>
                            <?php foreach ($purchases as $index => $purchase): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($purchase['full_name']) ?></td>
                                    <td><?= htmlspecialchars($purchase['email']) ?></td>
                                    <td><?= htmlspecialchars($purchase['phone_number']) ?></td>
                                    <td><?= htmlspecialchars($purchase['product_name']) ?></td>
                                    <td><?= $purchase['quantity'] ?></td>
                                    <td><?= number_format($purchase['unit_price'], 2) ?></td>
                                    <td><?= number_format($purchase['unit_price'] * $purchase['quantity'], 2) ?></td>
                                    <td><?= htmlspecialchars($purchase['payment_method']) ?></td>
                                    <td><?= htmlspecialchars($purchase['payment_date']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10" class="text-center">No purchases found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#purchaseTable').DataTable();
    });
</script>
</body>
</html>

<?php 
require 'session.php';
require 'connection.php';

// Fetch clients (role_id = 0)
$stmt = $pdo->prepare("SELECT user_id, username, full_name, email, phone_number, created_at, updated_at FROM users WHERE role_id = 0");
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link rel="stylesheet" href="style.css">
    <style>
        .custom-container {
            border: 3px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
        }
        .custom-table th { background-color: #007bff; color: white; text-align: center; }
        .custom-table td { text-align: center; vertical-align: middle; }
        .custom-header { background-color: #006eff; color: white; padding: 15px; font-size: 24px; font-weight: bold; border-radius: 10px; text-align: center; }
        .img-thumbnail { border-radius: 10px; max-width: 60px; max-height: 60px; }
        .btn-icon { width: 32px; height: 32px; }
        .action-buttons { display: flex; justify-content: center; gap: 5px; }
        .modal-body span { font-weight: bold; }
    </style>
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

<div class="container mt-4 custom-container">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-secondary me-2" onclick="window.print()">Print</button>
        <button class="btn btn-success" id="exportExcel">Export to Excel</button>
    </div>

    <table class="table table-striped table-bordered custom-table" id="clientsTable">
        <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($clients as $client): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($client['username']) ?></td>
                <td><?= htmlspecialchars($client['full_name']) ?></td>
                <td><?= htmlspecialchars($client['email']) ?></td>
                <td><?= htmlspecialchars($client['phone_number']) ?></td>
                <td class="action-buttons">
                    <button class="btn btn-info btn-sm btn-icon" title="Client Details"
                     onclick="showClientDetails(
                        '<?= htmlspecialchars($client['username']) ?>',
                        '<?= htmlspecialchars($client['created_at']) ?>',
                        '<?= htmlspecialchars($client['updated_at']) ?>'
                    )"><i class="bi bi-clock-history"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="clientDetailsModal" tabindex="-1" aria-labelledby="clientDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="clientDetailsLabel">Client Activity History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><span>Username:</span> <span id="modalUsername"></span></p>
                <p><span>Created At:</span> <span id="modalCreatedAt"></span></p>
                <p><span>Updated At:</span> <span id="modalUpdatedAt"></span></p>
                <p><span>Last Login:</span> <span id="modalLastLogin"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('#clientsTable').DataTable();
    });

    document.getElementById('exportExcel').addEventListener('click', function () {
        $('#clientsTable').tableExport({ type: 'excel', escape: 'false', fileName: 'Clients_List' });
    });

    function showClientDetails(username, createdAt, updatedAt, lastLogin) {
        document.getElementById('modalUsername').innerText = username || 'N/A';
        document.getElementById('modalCreatedAt').innerText = createdAt || 'N/A';
        document.getElementById('modalUpdatedAt').innerText = updatedAt || 'N/A';
        document.getElementById('modalLastLogin').innerText = lastLogin || 'N/A';
        var modal = new bootstrap.Modal(document.getElementById('clientDetailsModal'));
        modal.show();
    }
</script>
</body>
</html>

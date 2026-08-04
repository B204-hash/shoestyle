<?php 
require 'session.php';
require 'connection.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Admin Accounts</h4>
    </div>
    <div class="table-responsive mt-3">
        <table id="adminTable" class="table table-striped table-bordered">
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
                <?php
                try {
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE role_id = 1 ORDER BY created_at DESC");
                    $stmt->execute();
                    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $count = 1;

                    foreach ($admins as $admin):
                ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($admin['username']) ?></td>
                    <td><?= htmlspecialchars($admin['full_name']) ?></td>
                    <td><?= htmlspecialchars($admin['email']) ?></td>
                    <td><?= htmlspecialchars($admin['phone_number']) ?></td>
                    <td class="action-buttons">
                        <!-- View History -->
                        <button class="btn btn-info btn-sm btn-icon" title="View History"
                            onclick="showAdminHistory(
                                '<?= htmlspecialchars($admin['username']) ?>',
                                '<?= htmlspecialchars($admin['created_at']) ?>',
                                '<?= htmlspecialchars($admin['updated_at']) ?>'
                            )">
                            <i class="bi bi-clock-history"></i>
                        </button>

                        <!-- Edit -->
                        <a href="admin_edit.php?user_id=<?= $admin['user_id'] ?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <!-- Delete -->
                        <?php if ($admin['user_id'] != $_SESSION['user_id']): ?>
                        <a href="admin_delete.php?user_id=<?= $admin['user_id'] ?>" 
                           class="btn btn-danger btn-sm btn-icon" 
                           onclick="return confirm('Are you sure you want to delete this admin?');"
                           title="Delete">
                            <i class="bi bi-trash"></i>
                        </a>
                        <?php else: ?>
                        <span class="text-muted small">(you)</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                    endforeach;
                } catch (PDOException $e) {
                    echo '<tr><td colspan="6">Database error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Admin History -->
<div class="modal fade" id="adminHistoryModal" tabindex="-1" aria-labelledby="adminHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="adminHistoryModalLabel">Admin History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Username:</strong> <span id="adminUsername"></span></p>
                <p><strong>Created At:</strong> <span id="adminCreatedAt"></span></p>
                <p><strong>Last Updated:</strong> <span id="adminUpdatedAt"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#adminTable').DataTable({
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 10
    });
});

// Show modal function
function showAdminHistory(username, createdAt, updatedAt) {
    $('#adminUsername').text(username);
    $('#adminCreatedAt').text(createdAt);
    $('#adminUpdatedAt').text(updatedAt);
    $('#adminHistoryModal').modal('show');
}
</script>

</body>
</html>

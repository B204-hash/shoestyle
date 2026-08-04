<?php
session_start();
require_once 'admin/connection.php';
$page_title = "My Purchases";
require_once 'includes/navbar.php';


$user_id = $_SESSION['user_id'];

// Fetch client purchases
try {
    $stmt = $pdo->prepare("
        SELECT 
            p.product_name,
            pr.quantity,
            pr.unit_price,
            pi.final_price,
            pi.payment_method,
            pi.payment_date
        FROM users u
        JOIN card_details cd ON u.user_id = cd.user_id
        JOIN payment_info pi ON cd.card_id = pi.card_id
        JOIN purchases pr ON pi.payment_id = pr.payment_id
        JOIN products p ON pr.product_id = p.product_id
        WHERE u.user_id = :user_id
        ORDER BY pi.payment_date DESC
    ");

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p class='error'>Error retrieving purchases: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4 text-center"><?= $page_title ?></h3>

    <?php if (!empty($purchases)): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $purchase): ?>
                    <tr>
                        <td><?= htmlspecialchars($purchase['product_name']) ?></td>
                        <td><?= htmlspecialchars($purchase['quantity']) ?></td>
                        <td>$<?= number_format($purchase['unit_price'], 2) ?></td>
                        <td>$<?= number_format($purchase['final_price'], 2) ?></td>
                        <td><?= htmlspecialchars($purchase['payment_method']) ?></td>
                        <td><?= htmlspecialchars($purchase['payment_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">You haven't made any purchases yet.</p>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

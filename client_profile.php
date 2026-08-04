<?php
require_once 'session_client.php';
require_once 'admin/connection.php';


$userId = $_SESSION['user_id'];
$updateSuccess = $_GET['updated'] ?? false;
$client = [];

// Fetch user data from the database
try {
    $stmt = $pdo->prepare("SELECT email, username, full_name, phone_number, city, country, postal_code, created_at FROM users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

    if (!$client) {
        echo "<div class='alert alert-danger'>User not found.</div>";
        exit();
    }

    $email = $client['email'];

    // Handle profile update
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars(trim($_POST['username']));
        $name = htmlspecialchars(trim($_POST['name']));
        $mobile = htmlspecialchars(trim($_POST['mobile']));
        $city = htmlspecialchars(trim($_POST['city']));
        $country = htmlspecialchars(trim($_POST['country']));
        $postal = htmlspecialchars(trim($_POST['postal']));

        $update_stmt = $pdo->prepare("UPDATE users SET username = :username, full_name = :name, phone_number = :mobile, city = :city, country = :country, postal_code = :postal, updated_at = NOW() WHERE user_id = :user_id");
        $update_stmt->execute([
            'username' => $username,
            'name' => $name,
            'mobile' => $mobile,
            'city' => $city,
            'country' => $country,
            'postal' => $postal,
            'user_id' => $userId
        ]);

        header("Location: client_profile.php?updated=1");
        exit();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<?php $page_title = "My Profile"; include 'includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-success fw-bold">My Profile</h2>

        <?php if ($updateSuccess): ?>
            <div class="alert alert-success" id="updateSuccess">Your data was updated successfully.</div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($client['username'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($client['full_name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mobile Number</label>
                <input type="text" class="form-control" name="mobile" value="<?= htmlspecialchars($client['phone_number'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($client['city'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="country" value="<?= htmlspecialchars($client['country'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="postal" value="<?= htmlspecialchars($client['postal_code'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($email ?? '') ?>" readonly>
            </div>

            <div class="mb-3 text-muted">
                <strong>Reg Date:</strong> <?= htmlspecialchars($client['created_at'] ?? '') ?>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
<script>
    setTimeout(() => document.getElementById('updateSuccess')?.style.display = 'none', 10000);
</script>
</body>
</html>

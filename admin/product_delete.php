<?php
require 'session.php';
require 'connection.php';

if (!isset($_GET['product_id'])) {
    die("Product ID is required.");
}

$product_id = (int)$_GET['product_id'];

// Check if product exists before deleting
try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        die("Product not found.");
    }

    // If the product has an image, delete it from the server
    if (!empty($product['image']) && file_exists($product['image'])) {
        unlink($product['image']);
    }

    // Delete product from the database
    $deleteStmt = $pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
    $deleteStmt->execute([':product_id' => $product_id]);

    header("Location: product_view.php?msg=deleted");
    exit();
} catch (PDOException $e) {
    die("Error deleting product: " . htmlspecialchars($e->getMessage()));
}
?>

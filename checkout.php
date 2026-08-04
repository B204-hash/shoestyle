<?php
require 'session_client.php';
require 'admin/connection.php';

// Function to encrypt card details using AES-256-CBC
function encryptData($plainText, $key) {
    $cipher = "AES-256-CBC";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $encrypted = openssl_encrypt($plainText, $cipher, $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

$encryption_key = "your_super_secret_key_32chars";
$success = $error = '';
$orderSummary = [];
$finalPrice = 0;

// Process the cart if submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartData'])) {
    $cartItems = json_decode($_POST['cartData'], true);
    
    if (empty($cartItems)) {
        die(json_encode(['error' => 'Your cart is empty.']));
    }

    // Build order summary and check stock
    foreach ($cartItems as $productId => $quantity) {
        $stmt = $pdo->prepare("SELECT product_name, price, stock FROM products WHERE product_id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            if ($product['stock'] < $quantity) {
                die(json_encode(['error' => "Not enough stock for {$product['product_name']}. Only {$product['stock']} left."]));
            }

            $subtotal = $product['price'] * $quantity;
            $finalPrice += $subtotal;

            $orderSummary[] = [
                'id' => $productId,
                'name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
    }

    // 10% discount if over $500
    if ($finalPrice >= 500) {
        $finalPrice *= 0.9;
        $finalPrice = round($finalPrice, 2);
    }

    // Return JSON response for AJAX
    header('Content-Type: application/json');
    echo json_encode([
        'orderSummary' => $orderSummary,
        'finalPrice' => $finalPrice
    ]);
    exit;
}

// Handle the actual payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cardHolderName'])) {
    $cardHolderName = htmlspecialchars($_POST['cardHolderName']);
    $cardNumber = str_replace(' ', '', $_POST['cardNumber']);
    $cardNumberEnc = encryptData($cardNumber, $encryption_key);
    $cardCVCEnc = encryptData($_POST['cardCVC'], $encryption_key);
    $cardExpiry = htmlspecialchars($_POST['cardExpiry']);
    $userId = $_SESSION['user_id'];
    $orderData = json_decode($_POST['orderData'], true);

    try {
        // 1. Save card details
        $stmt = $pdo->prepare("INSERT INTO card_details (card_holder_name, card_cvv_enc, card_exp_date, card_nr_enc, created_at, user_id) VALUES (?, ?, ?, ?, NOW(), ?)");
        $stmt->execute([$cardHolderName, $cardCVCEnc, $cardExpiry, $cardNumberEnc, $userId]);
        $cardId = $pdo->lastInsertId();

        // 2. Save payment info
        $stmt = $pdo->prepare("INSERT INTO payment_info (final_price, payment_method, payment_date, card_id) VALUES (?, 'card', NOW(), ?)");
        $stmt->execute([$orderData['finalPrice'], $cardId]);
        $paymentId = $pdo->lastInsertId();

        // 3. Save purchases and update stock
        foreach ($orderData['orderSummary'] as $item) {
            // Save each purchase
            $stmt = $pdo->prepare("INSERT INTO purchases (payment_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $paymentId,
                $item['id'],
                $item['quantity'],
                $item['price']
            ]);

            // Update stock for each product
            $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ? AND stock >= ?");
            $stmt->execute([$item['quantity'], $item['id'], $item['quantity']]);
        }

        $success = "Payment successful! Thank you for your purchase.";
        echo json_encode(['success' => $success]);
        exit;

    } catch (PDOException $e) {
        $error = "Payment failed: " . $e->getMessage();
        echo json_encode(['error' => $error]);
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 900px; }
        .loading { display: none; }
        #payment-result { display: none; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div id="checkout-container">
        
        <div class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p>Loading your cart...</p>
        </div>
    </div>
    
    <!-- Payment results-->
    <div id="payment-result" class="text-center mt-5">
        <div id="payment-message" class="alert"></div>
        <a href="products.php" class="btn btn-primary">Return to Shop</a>
    </div>
</div>
<script src="js/checkout.js"></script>

</body>
</html>
<?php
require_once dirname(__DIR__) . '/includes/init.php';

// Require customer login
requireRole(ROLE_CUSTOMER);

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $product_id = (int)$_POST['product_id'] ?? 0;
        $quantity = (int)$_POST['quantity'] ?? 1;
        
        if ($product_id <= 0 || $quantity <= 0) {
            throw new Exception('Invalid product or quantity');
        }
        
        $customer = new Customer($user_id);
        $customer->addToCart($product_id, $quantity);
        
        showSuccess('Product added to cart successfully!');
    } catch (Exception $e) {
        showError($e->getMessage());
        logError('Add to cart error', ['user_id' => $user_id, 'error' => $e->getMessage()]);
    }
}

// Redirect back to shop
header('Location: shop.php');
exit;
?>

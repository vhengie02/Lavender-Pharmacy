<?php
require_once dirname(__DIR__) . '/includes/init.php';

requireRole(ROLE_CUSTOMER);

$user_id = $_SESSION['user_id'];
$customer = new Customer($user_id);

// Handle remove from cart
if (isset($_POST['remove_item'])) {
    try {
        $customer->removeFromCart((int)$_POST['remove_item']);
        showSuccess('Item removed from cart');
        header('Location: cart.php');
        exit;
    } catch (Exception $e) {
        showError($e->getMessage());
    }
}

// Handle update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    try {
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'quantity_') === 0) {
                $cart_id = (int)str_replace('quantity_', '', $key);
                $quantity = (int)$value;
                if ($quantity > 0) {
                    $customer->updateCartQuantity($cart_id, $quantity);
                }
            }
        }
        showSuccess('Cart updated successfully');
        header('Location: cart.php');
        exit;
    } catch (Exception $e) {
        showError($e->getMessage());
    }
}

$cart_items = $customer->getCart();
$total_amount = 0;

foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

$page_title = 'Shopping Cart';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --lavender: #B57EDC;
            --soft-purple: #C8A2C8;
            --dark-violet: #5D3A66;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender) 0%, var(--soft-purple) 100%);
        }
        
        .cart-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .btn-checkout {
            background-color: var(--lavender);
            border: none;
            color: white;
            padding: 12px 30px;
        }
        
        .btn-checkout:hover {
            background-color: var(--dark-violet);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo APP_URL; ?>">
                <i class="fas fa-flower"></i> <?php echo APP_NAME; ?>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php"><i class="fas fa-store"></i> Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Messages -->
    <div class="container mt-4">
        <?php if ($error = getError()): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($success = getSuccess()): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Cart Content -->
    <div class="container my-4">
        <h2 class="mb-4" style="color: var(--dark-violet);">
            <i class="fas fa-shopping-cart"></i> Shopping Cart
        </h2>
        
        <?php if (empty($cart_items)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Your cart is empty. 
                <a href="shop.php" class="alert-link">Continue shopping</a>
            </div>
        <?php else: ?>
            <form method="POST" action="cart.php">
                <div class="row">
                    <div class="col-md-8">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-item">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="text-center" style="background: linear-gradient(135deg, #E6E6FA 0%, #C8A2C8 100%); padding: 20px; border-radius: 8px; color: white;">
                                            <i class="fas fa-pill fa-2x"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h5><?php echo htmlspecialchars($item['product_name']); ?></h5>
                                        <p class="text-muted small">SKU: #<?php echo $item['product_id']; ?></p>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <p class="mb-0"><strong><?php echo formatCurrency($item['price']); ?></strong></p>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="quantity_<?php echo $item['cart_id']; ?>" 
                                               value="<?php echo $item['quantity']; ?>" min="1" class="form-control" style="max-width: 80px;">
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <p class="mb-0"><strong><?php echo formatCurrency($item['price'] * $item['quantity']); ?></strong></p>
                                        <form method="POST" action="cart.php" style="display: inline;">
                                            <input type="hidden" name="remove_item" value="<?php echo $item['cart_id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger mt-2" onclick="return confirm('Remove this item from cart?');">
                                                <i class="fas fa-trash"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="mt-3">
                            <button type="submit" name="update_cart" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-sync"></i> Update Cart
                            </button>
                            <a href="shop.php" class="btn btn-outline-secondary">
                                <i class="fas fa-shopping-bag"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Order Summary</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span><?php echo formatCurrency($total_amount); ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>VAT (12%):</span>
                                    <span><?php echo formatCurrency($total_amount * 0.12); ?></span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Total:</h6>
                                    <h6 style="color: var(--lavender);">
                                        <?php echo formatCurrency($total_amount * 1.12); ?>
                                    </h6>
                                </div>
                                <a href="checkout.php" class="btn btn-checkout w-100">
                                    <i class="fas fa-credit-card"></i> Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

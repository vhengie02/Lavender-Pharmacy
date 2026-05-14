<?php
require_once dirname(__DIR__) . '/includes/init.php';

requireRole(ROLE_CUSTOMER);

$user_id = $_SESSION['user_id'];
$customer = new Customer($user_id);
$cart_items = $customer->getCart();

if (empty($cart_items)) {
    showError('Your cart is empty');
    header('Location: cart.php');
    exit;
}

$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

$vat_amount = $total_amount * 0.12;
$grand_total = $total_amount + $vat_amount;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $payment_method = sanitize($_POST['payment_method'] ?? '');
        $cash_tendered = isset($_POST['cash_tendered']) ? (float)$_POST['cash_tendered'] : null;
        
        if (!in_array($payment_method, PAYMENT_METHODS)) {
            throw new Exception('Invalid payment method');
        }
        
        // Create order
        $order = new Order();
        $order_id = $order->createOrder($user_id, $payment_method);
        
        // Generate receipt
        $receipt = new Receipt();
        $receipt->generateReceipt($order_id, $cash_tendered);
        
        showSuccess('Order placed successfully! Receipt generated.');
        header('Location: order_receipt.php?order_id=' . $order_id);
        exit;
    } catch (Exception $e) {
        showError($e->getMessage());
        logError('Checkout error', ['user_id' => $user_id, 'error' => $e->getMessage()]);
    }
}

$page_title = 'Checkout';
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
        
        .btn-place-order {
            background-color: var(--lavender);
            border: none;
            color: white;
            padding: 12px 30px;
        }
        
        .btn-place-order:hover {
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
        </div>
    </nav>
    
    <!-- Checkout Content -->
    <div class="container my-4">
        <h2 class="mb-4" style="color: var(--dark-violet);">
            <i class="fas fa-credit-card"></i> Checkout
        </h2>
        
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-header" style="background-color: var(--lavender); color: white;">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                        <td><?php echo $item['quantity']; ?></td>
                                        <td><?php echo formatCurrency($item['price']); ?></td>
                                        <td><?php echo formatCurrency($item['price'] * $item['quantity']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <form method="POST" action="checkout.php">
                    <div class="card">
                        <div class="card-header" style="background-color: var(--lavender); color: white;">
                            <h5 class="mb-0">Payment Method</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="cash" id="cash" required checked>
                                    <label class="form-check-label" for="cash">
                                        <i class="fas fa-money-bill"></i> Cash Payment
                                    </label>
                                </div>
                                <div id="cash_fields" class="mt-3">
                                    <label for="cash_tendered" class="form-label">Amount Tendered</label>
                                    <input type="number" name="cash_tendered" id="cash_tendered" class="form-control" 
                                           step="0.01" min="<?php echo $grand_total; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="gcash" id="gcash">
                                    <label class="form-check-label" for="gcash">
                                        <i class="fas fa-mobile-alt"></i> GCash
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" value="card" id="card">
                                    <label class="form-check-label" for="card">
                                        <i class="fas fa-credit-card"></i> Credit/Debit Card
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="cart.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </a>
                        <button type="submit" class="btn btn-place-order">
                            <i class="fas fa-check"></i> Place Order
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="col-md-5">
                <div class="card" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                    <div class="card-header" style="background-color: var(--lavender); color: white;">
                        <h5 class="mb-0">Order Total</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span><?php echo formatCurrency($total_amount); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>VAT (12%):</span>
                            <span><?php echo formatCurrency($vat_amount); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6><strong>Grand Total:</strong></h6>
                            <h6 style="color: var(--lavender); font-weight: bold; font-size: 1.5rem;">
                                <?php echo formatCurrency($grand_total); ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Handle payment method change
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const cashFields = document.getElementById('cash_fields');
                if (this.value === 'cash') {
                    cashFields.style.display = 'block';
                    document.getElementById('cash_tendered').required = true;
                } else {
                    cashFields.style.display = 'none';
                    document.getElementById('cash_tendered').required = false;
                }
            });
        });
    </script>
</body>
</html>

<?php
require_once dirname(__DIR__) . '/includes/init.php';

requireRole(ROLE_CUSTOMER);

$user_id = $_SESSION['user_id'];
$customer = new Customer($user_id);
$orders = $customer->getOrderHistory();

$page_title = 'My Orders';
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
            --dark-violet: #5D3A66;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender) 0%, var(--soft-purple) 100%);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        
        .status-pending {
            background-color: #ffc107;
            color: black;
        }
        
        .status-completed {
            background-color: #28a745;
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
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php"><i class="fas fa-store"></i> Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="orders.php"><i class="fas fa-history"></i> My Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container my-4">
        <h2 class="mb-4" style="color: var(--dark-violet);">
            <i class="fas fa-history"></i> My Orders
        </h2>
        
        <?php if (empty($orders)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> You have no orders yet. 
                <a href="shop.php" class="alert-link">Start shopping</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background-color: var(--lavender); color: white;">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['order_id']; ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($order['date_ordered'])); ?></td>
                                <td>
                                    <?php 
                                    $items = $customer->getOrderDetails($order['order_id']);
                                    echo count($items) . ' item' . (count($items) !== 1 ? 's' : '');
                                    ?>
                                </td>
                                <td><?php echo formatCurrency($order['total_amount']); ?></td>
                                <td><?php echo ucfirst($order['payment_method']); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                        <?php echo ucfirst($order['order_status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="order_receipt.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-receipt"></i> Receipt
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <div class="mt-4">
            <a href="shop.php" class="btn btn-outline-secondary">
                <i class="fas fa-store"></i> Continue Shopping
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

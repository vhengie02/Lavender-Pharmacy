<?php
require_once dirname(__DIR__) . '/includes/init.php';

requireRole(ROLE_CUSTOMER);

$order_id = (int)($_GET['order_id'] ?? 0);

if ($order_id <= 0) {
    showError('Invalid order ID');
    header('Location: shop.php');
    exit;
}

// Get receipt
$db = Database::getInstance()->getConnection();
$query = "SELECT r.* FROM receipts r 
         JOIN orders o ON r.order_id = o.order_id 
         WHERE r.order_id = ? AND o.user_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ii', $order_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    showError('Receipt not found');
    header('Location: shop.php');
    exit;
}

$receipt_data = $result->fetch_assoc();
$stmt->close();

// Create receipt object to get HTML
$receipt = new Receipt($receipt_data['receipt_id']);

$page_title = 'Order Receipt';
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
        
        .receipt-container {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-print {
            background-color: var(--lavender);
            border: none;
            color: white;
        }
        
        .btn-print:hover {
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
    
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 style="color: var(--dark-violet);">
                    <i class="fas fa-receipt"></i> Order Receipt
                </h2>
                <p class="text-muted">Invoice #<?php echo htmlspecialchars($receipt_data['invoice_number']); ?></p>
            </div>
        </div>
        
        <div class="receipt-container" id="receipt">
            <?php echo $receipt->getReceiptHTML(); ?>
        </div>
        
        <div class="mt-4">
            <button class="btn btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Print Receipt
            </button>
            <a href="orders.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

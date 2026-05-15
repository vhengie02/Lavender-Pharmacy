<?php
require_once dirname(__DIR__) . '/includes/init.php';

requireRole(ROLE_EDITOR);

$editor = new Editor($_SESSION['user_id']);
$page_title = 'My Products';

// Get editor's products
$db = Database::getInstance()->getConnection();
$result = $db->query("SELECT * FROM products WHERE created_by = {$_SESSION['user_id']} ORDER BY product_name ASC");
$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
    <style>
        :root {
            --lavender: #B57EDC;
            --soft-purple: #C8A2C8;
            --dark-violet: #5D3A66;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender) 0%, var(--soft-purple) 100%);
        }
        
        .product-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(181, 126, 220, 0.3);
        }
        
        .product-image {
            height: 200px;
            background: linear-gradient(135deg, #E6E6FA 0%, #C8A2C8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        
        .btn-primary-lavender {
            background-color: var(--lavender);
            border: none;
            color: white;
        }
        
        .btn-primary-lavender:hover {
            background-color: var(--dark-violet);
            color: white;
        }
        
        .btn-add-product {
            background: white;
            border: 2px solid var(--lavender);
            color: var(--lavender);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 250px;
        }
        
        .btn-add-product:hover {
            background-color: var(--lavender);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(181, 126, 220, 0.3);
        }
        
        .btn-add-product i {
            font-size: 2.5rem;
            margin-bottom: 10px;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="products.php"><i class="fas fa-pills"></i> My Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>profile.php"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container my-4">
        <h2 class="mb-4" style="color: var(--dark-violet);">
            <i class="fas fa-pills"></i> My Products
        </h2>
        
        <?php if (empty($products)): ?>
            <div class="row">
                <div class="col-md-3">
                    <a href="products.php?action=add" class="btn-add-product">
                        <i class="fas fa-plus-circle"></i>
                        <h5>Add Your First Product</h5>
                        <p class="small text-muted">Create and manage products</p>
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <div class="col-md-3">
                    <a href="products.php?action=add" class="btn-add-product">
                        <i class="fas fa-plus-circle"></i>
                        <h5>Add New Product</h5>
                    </a>
                </div>
                
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3">
                        <div class="card product-card h-100">
                            <div class="product-image">
                                <i class="fas fa-pill"></i>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                <p class="card-text text-muted small">
                                    <?php echo htmlspecialchars($product['generic_name'] ?? 'N/A'); ?>
                                </p>
                                <div class="my-2">
                                    <span class="badge bg-success">Stock: <?php echo $product['stock_quantity']; ?></span>
                                </div>
                                <h4 style="color: var(--lavender);">
                                    <?php echo formatCurrency($product['price']); ?>
                                </h4>
                                <p class="card-text small"><?php echo htmlspecialchars(substr($product['description'] ?? '', 0, 60)); ?>...</p>
                            </div>
                            <div class="card-footer bg-transparent border-top">
                                <button class="btn btn-primary-lavender btn-sm w-100" title="Edit" onclick="editProduct(<?php echo $product['product_id']; ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        function editProduct(productId) {
            // Placeholder for edit functionality
            Swal.fire({
                title: 'Edit Product',
                text: 'Product editing functionality coming soon',
                icon: 'info'
            });
        }
    </script>
</body>
</html>

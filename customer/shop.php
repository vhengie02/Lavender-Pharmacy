<?php
require_once dirname(__DIR__) . '/includes/init.php';

// Require customer login
requireRole(ROLE_CUSTOMER);

$page_title = 'Shop';

// Get all products or search results
$products = [];
$search_term = sanitize($_GET['search'] ?? '');

if (!empty($search_term)) {
    $products = Product::searchProducts($search_term);
} else {
    $products = Product::getAllProducts();
}

// Get categories
$db = Database::getInstance()->getConnection();
$categories = $db->query("SELECT * FROM categories ORDER BY category_name ASC")->fetch_all(MYSQLI_ASSOC);
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
        
        .product-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
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
        }
        
        .btn-add-cart {
            background-color: var(--lavender);
            border: none;
            color: white;
        }
        
        .btn-add-cart:hover {
            background-color: var(--dark-violet);
            color: white;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender) 0%, var(--soft-purple) 100%);
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
                        <a class="nav-link active" href="shop.php"><i class="fas fa-store"></i> Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php"><i class="fas fa-history"></i> My Orders</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Search Bar -->
    <div class="container-fluid bg-white py-3 shadow-sm">
        <div class="container">
            <form method="GET" action="shop.php" class="d-flex gap-2">
                <input type="text" class="form-control" name="search" placeholder="Search products..." 
                       value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit" class="btn btn-lavender">
                    <i class="fas fa-search"></i> Search
                </button>
                <?php if (!empty($search_term)): ?>
                    <a href="shop.php" class="btn btn-outline-secondary">Clear</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container my-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4" style="color: var(--dark-violet);">
                    <i class="fas fa-pills"></i> 
                    <?php echo !empty($search_term) ? 'Search Results for: ' . htmlspecialchars($search_term) : 'Product Catalog'; ?>
                </h2>
                
                <?php if (empty($products)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No products available.
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="card product-card">
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
                                        <h4 class="text-lavender" style="color: var(--lavender);">
                                            <?php echo formatCurrency($product['price']); ?>
                                        </h4>
                                        <p class="card-text small"><?php echo htmlspecialchars(substr($product['description'] ?? '', 0, 60)); ?>...</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-top">
                                        <button class="btn btn-add-cart btn-sm w-100" onclick="addToCart(<?php echo $product['product_id']; ?>, '<?php echo htmlspecialchars($product['product_name']); ?>')">
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        function addToCart(productId, productName) {
            const quantity = prompt('How many do you want to add?', '1');
            if (quantity !== null && parseInt(quantity) > 0) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'add_to_cart.php';
                
                const productInput = document.createElement('input');
                productInput.type = 'hidden';
                productInput.name = 'product_id';
                productInput.value = productId;
                
                const quantityInput = document.createElement('input');
                quantityInput.type = 'hidden';
                quantityInput.name = 'quantity';
                quantityInput.value = quantity;
                
                form.appendChild(productInput);
                form.appendChild(quantityInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>

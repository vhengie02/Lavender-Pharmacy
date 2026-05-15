<?php
require_once dirname(__DIR__) . '/includes/init.php';

requireRole(ROLE_EDITOR);

$editor = new Editor($_SESSION['user_id']);
$page_title = 'Editor Dashboard';

// Get editor stats
$db = Database::getInstance()->getConnection();
$my_products = $db->query("SELECT COUNT(*) as count FROM products WHERE created_by = {$_SESSION['user_id']}")->fetch_assoc();
$total_sales = $db->query("SELECT SUM(total_amount) as amount FROM orders WHERE status = 'completed'")->fetch_assoc();
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
        
        body {
            background-color: #f8f9fa;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender) 0%, var(--soft-purple) 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            border: none;
            border-left: 4px solid var(--lavender);
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-radius: 10px;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(181, 126, 220, 0.3);
        }
        
        .stat-icon {
            font-size: 2rem;
            color: var(--lavender);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--dark-violet);
        }
        
        .quick-action {
            background: white;
            border: 2px solid var(--lavender);
            color: var(--lavender);
            padding: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }
        
        .quick-action:hover {
            background-color: var(--lavender);
            color: white;
            transform: translateY(-5px);
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
                        <a class="nav-link active" href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php"><i class="fas fa-pills"></i> My Products</a>
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
    
    <!-- Dashboard Content -->
    <div class="container-fluid my-4">
        <h2 class="mb-4" style="color: var(--dark-violet);">
            <i class="fas fa-tachometer-alt"></i> Editor Dashboard
        </h2>
        
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted mb-2">My Products</h6>
                                <div class="stat-number"><?php echo $my_products['count'] ?? 0; ?></div>
                            </div>
                            <i class="fas fa-pills stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted mb-2">Published</h6>
                                <div class="stat-number"><?php echo $my_products['count'] ?? 0; ?></div>
                            </div>
                            <i class="fas fa-check-circle stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted mb-2">Total Views</h6>
                                <div class="stat-number">0</div>
                            </div>
                            <i class="fas fa-eye stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted mb-2">Total Sales</h6>
                                <div class="stat-number"><?php echo formatCurrency($total_sales['amount'] ?? 0); ?></div>
                            </div>
                            <i class="fas fa-money-bill stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row g-4 mt-5">
            <div class="col-md-12">
                <h4 style="color: var(--dark-violet);">Quick Actions</h4>
            </div>
            <div class="col-md-3">
                <a href="products.php" class="quick-action text-center">
                    <i class="fas fa-pills" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2">View My Products</h5>
                    <p class="small">Manage your product catalog</p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="products.php?action=add" class="quick-action text-center">
                    <i class="fas fa-plus-circle" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2">Add New Product</h5>
                    <p class="small">Create a new product</p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?php echo APP_URL; ?>profile.php" class="quick-action text-center">
                    <i class="fas fa-user-cog" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2">Edit Profile</h5>
                    <p class="small">Update your information</p>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?php echo APP_URL; ?>logout.php" class="quick-action text-center" style="border-color: #dc3545; color: #dc3545;">
                    <i class="fas fa-sign-out-alt" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2">Logout</h5>
                    <p class="small">Exit the system</p>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

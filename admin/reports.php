<?php
require_once dirname(__DIR__) . '/includes/init.php';

requireRole(ROLE_ADMIN);

$admin = new Admin($_SESSION['user_id']);
$page_title = 'Reports';

// Get report data
$db = Database::getInstance()->getConnection();
$stats = $admin->getDashboardStats();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.css">
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
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(181, 126, 220, 0.3);
        }
        
        .stat-card {
            border-left: 4px solid var(--lavender);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--dark-violet);
        }
        
        .report-section {
            margin-bottom: 30px;
        }
        
        .btn-export {
            background-color: var(--lavender);
            border: none;
            color: white;
        }
        
        .btn-export:hover {
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php"><i class="fas fa-pills"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php"><i class="fas fa-users"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container-fluid my-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 style="color: var(--dark-violet);">
                    <i class="fas fa-chart-bar"></i> Reports
                </h2>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-export" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
        </div>
        
        <!-- Summary Statistics -->
        <div class="report-section">
            <h4 class="mb-3" style="color: var(--dark-violet);">Summary Statistics</h4>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Total Users</h6>
                                    <div class="stat-number"><?php echo $stats['total_users']; ?></div>
                                </div>
                                <i class="fas fa-users" style="font-size: 2rem; color: var(--lavender); opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Total Products</h6>
                                    <div class="stat-number"><?php echo $stats['total_products']; ?></div>
                                </div>
                                <i class="fas fa-pills" style="font-size: 2rem; color: var(--lavender); opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Total Orders</h6>
                                    <div class="stat-number"><?php echo $stats['total_orders']; ?></div>
                                </div>
                                <i class="fas fa-shopping-cart" style="font-size: 2rem; color: var(--lavender); opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title text-muted mb-2">Total Revenue</h6>
                                    <div class="stat-number"><?php echo formatCurrency($stats['month_sales']); ?></div>
                                </div>
                                <i class="fas fa-money-bill" style="font-size: 2rem; color: var(--lavender); opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sales Information -->
        <div class="report-section">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: var(--lavender); color: white;">
                            <h5 class="mb-0">Today's Sales</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-muted">Total Sales</p>
                                <h2 class="stat-number"><?php echo formatCurrency($stats['today_sales']); ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: var(--lavender); color: white;">
                            <h5 class="mb-0">This Month's Sales</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <p class="text-muted">Total Sales</p>
                                <h2 class="stat-number"><?php echo formatCurrency($stats['month_sales']); ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Inventory Information -->
        <div class="report-section">
            <h4 class="mb-3" style="color: var(--dark-violet);">Inventory Status</h4>
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #ffc107;"></i>
                            <h5 class="mt-3">Low Stock Products</h5>
                            <h3 class="stat-number"><?php echo $stats['low_stock']; ?></h3>
                            <p class="text-muted">Products below 10 units</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-check-circle" style="font-size: 2rem; color: #28a745;"></i>
                            <h5 class="mt-3">In Stock</h5>
                            <h3 class="stat-number"><?php echo $stats['total_products'] - $stats['low_stock']; ?></h3>
                            <p class="text-muted">Products in good stock</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-cubes" style="font-size: 2rem; color: var(--lavender);"></i>
                            <h5 class="mt-3">Total Products</h5>
                            <h3 class="stat-number"><?php echo $stats['total_products']; ?></h3>
                            <p class="text-muted">In inventory</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</body>
</html>

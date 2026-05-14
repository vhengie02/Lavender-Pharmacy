<?php
require_once dirname(__DIR__) . '/includes/init.php';

requireRole(ROLE_ADMIN);

$admin = new Admin($_SESSION['user_id']);
$stats = $admin->getDashboardStats();

$page_title = 'Admin Dashboard';
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
        
        .stat-card {
            border: none;
            border-left: 4px solid var(--lavender);
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
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
                        <a class="nav-link" href="products.php"><i class="fas fa-pills"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php"><i class="fas fa-users"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
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
            <i class="fas fa-tachometer-alt"></i> Admin Dashboard
        </h2>
        
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted mb-2">Total Users</h6>
                                <div class="stat-number"><?php echo $stats['total_users']; ?></div>
                            </div>
                            <i class="fas fa-users stat-icon"></i>
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
                                <h6 class="card-title text-muted mb-2">Total Orders</h6>
                                <div class="stat-number"><?php echo $stats['total_orders']; ?></div>
                            </div>
                            <i class="fas fa-shopping-cart stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title text-muted mb-2">Today's Sales</h6>
                                <div class="stat-number"><?php echo formatCurrency($stats['today_sales']); ?></div>
                            </div>
                            <i class="fas fa-money-bill stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Stats -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: var(--lavender); color: white;">
                        <h5 class="mb-0">Monthly Sales</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">This Month's Total</p>
                                <h3 class="stat-number"><?php echo formatCurrency($stats['month_sales']); ?></h3>
                            </div>
                            <i class="fas fa-chart-area" style="font-size: 2.5rem; color: var(--soft-purple); opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: var(--lavender); color: white;">
                        <h5 class="mb-0">Inventory Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Low Stock Products</p>
                                <h3 class="stat-number"><?php echo $stats['low_stock']; ?></h3>
                            </div>
                            <i class="fas fa-exclamation-triangle" style="font-size: 2.5rem; color: #ffc107; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="row g-4 mt-4">
            <div class="col-md-3">
                <a href="products.php" class="btn btn-outline-lavender w-100" style="border-color: var(--lavender); color: var(--lavender); padding: 15px;">
                    <i class="fas fa-pills"></i> Manage Products
                </a>
            </div>
            <div class="col-md-3">
                <a href="users.php" class="btn btn-outline-lavender w-100" style="border-color: var(--lavender); color: var(--lavender); padding: 15px;">
                    <i class="fas fa-users"></i> Manage Users
                </a>
            </div>
            <div class="col-md-3">
                <a href="reports.php" class="btn btn-outline-lavender w-100" style="border-color: var(--lavender); color: var(--lavender); padding: 15px;">
                    <i class="fas fa-chart-bar"></i> View Reports
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?php echo APP_URL; ?>logout.php" class="btn btn-outline-danger w-100" style="padding: 15px;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</body>
</html>

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
            --white: #FFFFFF;
            --light-lilac: #E6E6FA;
            --dark-violet: #5D3A66;
        }
        
        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container-fluid {
            background: #f5f5f5;
            margin-left: 130px;
            padding: 20px 30px !important;
        }
        
        .navbar {
            display: none;
        }
        
        .dashboard-header {
            margin-bottom: 25px;
            border-bottom: 3px solid var(--lavender);
            padding-bottom: 15px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 0 0 25px 0;
        }
        
        .dashboard-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-violet);
            margin-bottom: 5px;
        }
        
        .dashboard-header p {
            font-size: 0.95rem;
            color: #888;
            margin: 0;
        }
        
        .stat-card {
            background: white;
            border: none;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transition: all 0.3s ease;
            height: 100%;
            border-left: 4px solid var(--lavender);
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(181, 126, 220, 0.25);
            border-left-color: var(--dark-violet);
        }
        
        .stat-card .card-body {
            padding: 0;
        }
        
        .stat-card .card-title {
            font-size: 0.85rem !important;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-icon {
            font-size: 2.2rem;
            color: var(--lavender);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-violet);
        }
        
        .card {
            border: none;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 6px 16px rgba(181, 126, 220, 0.2);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--lavender) 0%, var(--soft-purple) 100%) !important;
            color: white;
            border: none;
            border-radius: 8px 8px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .card-header h5 {
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .quick-link-btn {
            border: 2px solid var(--lavender);
            padding: 12px 16px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: white;
            color: var(--lavender);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .quick-link-btn:hover {
            background: var(--lavender);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(181, 126, 220, 0.3);
            text-decoration: none;
        }
        
        .quick-link-btn i {
            margin-right: 8px;
        }
        
        .logout-btn {
            border-color: #dc3545;
            color: #dc3545;
        }
        
        .logout-btn:hover {
            background: #dc3545;
            color: white;
            box-shadow: 0 6px 12px rgba(220, 53, 69, 0.3);
        }
        
        footer {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Dashboard Content -->
    <div class="container-fluid p-4">
        <div class="dashboard-header mb-4">
            <h2>
                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
            </h2>
            <p class="text-muted">Here's your system overview</p>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
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
            
            <div class="col-lg-3 col-md-6">
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
            
            <div class="col-lg-3 col-md-6">
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
            
            <div class="col-lg-3 col-md-6">
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
        <div class="row g-3 mb-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Monthly Sales</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">This Month's Total</p>
                                <h3 class="stat-number"><?php echo formatCurrency($stats['month_sales']); ?></h3>
                            </div>
                            <i class="fas fa-chart-area" style="font-size: 2.2rem; color: var(--soft-purple); opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Inventory Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-2">Low Stock Products</p>
                                <h3 class="stat-number"><?php echo $stats['low_stock']; ?></h3>
                            </div>
                            <i class="fas fa-exclamation-triangle" style="font-size: 2.2rem; color: #ffc107; opacity: 0.5;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="row g-3 mt-2">
            <div class="col-lg-3 col-md-6">
                <a href="products.php" class="btn quick-link-btn w-100">
                    <i class="fas fa-pills"></i> Manage Products
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="users.php" class="btn quick-link-btn w-100">
                    <i class="fas fa-users"></i> Manage Users
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="reports.php" class="btn quick-link-btn w-100">
                    <i class="fas fa-chart-bar"></i> View Reports
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="<?php echo APP_URL; ?>logout.php" class="btn quick-link-btn logout-btn w-100">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
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
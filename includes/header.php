<?php
/**
 * Header Include - Navigation and common header elements
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - ' : ''; ?><?php echo APP_NAME; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>assets/css/style.css">
    
    <style>
        :root {
            --lavender: #B57EDC;
            --soft-purple: #C8A2C8;
            --white: #FFFFFF;
            --light-lilac: #E6E6FA;
            --dark-violet: #5D3A66;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender) 0%, var(--soft-purple) 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-link {
            color: white !important;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: #FFF !important;
            text-shadow: 0 0 8px rgba(255,255,255,0.5);
        }
        
        .btn-lavender {
            background-color: var(--lavender);
            border-color: var(--lavender);
            color: white;
        }
        
        .btn-lavender:hover {
            background-color: var(--dark-violet);
            border-color: var(--dark-violet);
            color: white;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(181, 126, 220, 0.3);
            transform: translateY(-2px);
        }
        
        .badge-lavender {
            background-color: var(--lavender);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo APP_URL; ?>">
                <i class="fas fa-flower"></i>
                <?php echo APP_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isLoggedIn()): ?>
                        <?php if (hasRole(ROLE_CUSTOMER)): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>customer/shop.php">
                                    <i class="fas fa-store"></i> Shop
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>customer/cart.php">
                                    <i class="fas fa-shopping-cart"></i> Cart
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>customer/orders.php">
                                    <i class="fas fa-history"></i> My Orders
                                </a>
                            </li>
                        <?php elseif (hasRole(ROLE_ADMIN)): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>admin/dashboard.php">
                                    <i class="fas fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>admin/products.php">
                                    <i class="fas fa-pills"></i> Products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>admin/users.php">
                                    <i class="fas fa-users"></i> Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>admin/reports.php">
                                    <i class="fas fa-chart-bar"></i> Reports
                                </a>
                            </li>
                        <?php elseif (hasRole(ROLE_EDITOR)): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>editor/products.php">
                                    <i class="fas fa-edit"></i> Manage Products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo APP_URL; ?>editor/inventory.php">
                                    <i class="fas fa-warehouse"></i> Inventory
                                </a>
                            </li>
                        <?php endif; ?>
                        
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
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo APP_URL; ?>register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Messages -->
    <div class="container-fluid mt-3">
        <?php 
        $error = getError();
        $success = getSuccess();
        
        if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

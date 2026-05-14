<?php
require_once 'includes/init.php';

if (isLoggedIn()) {
    // Redirect to appropriate dashboard based on role
    if (hasRole(ROLE_ADMIN)) {
        header('Location: ' . APP_URL . 'admin/dashboard.php');
    } elseif (hasRole(ROLE_EDITOR)) {
        header('Location: ' . APP_URL . 'editor/products.php');
    } else {
        header('Location: ' . APP_URL . 'customer/shop.php');
    }
    exit;
}

$page_title = 'Home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Professional Pharmacy Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --lavender: #B57EDC;
            --soft-purple: #C8A2C8;
            --white: #FFFFFF;
            --light-lilac: #E6E6FA;
            --dark-violet: #5D3A66;
        }
        
        body {
            background: linear-gradient(135deg, #E6E6FA 0%, #C8A2C8 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender) 0%, var(--soft-purple) 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .hero {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero-content h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-content p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }
        
        .btn-lavender {
            background-color: white;
            color: var(--lavender);
            border: 2px solid white;
            padding: 12px 30px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-lavender:hover {
            background-color: var(--lavender);
            color: white;
            transform: scale(1.05);
        }
        
        .feature-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(181, 126, 220, 0.3);
        }
        
        .feature-card i {
            color: var(--lavender);
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <i class="fas fa-flower"></i> <?php echo APP_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content">
            <h1>
                <i class="fas fa-hospital" style="color: white;"></i>
                Lavender Pharmacy
            </h1>
            <p>Professional Pharmacy Management & E-Commerce System</p>
            <a href="register.php" class="btn btn-lavender btn-lg me-2">Get Started</a>
            <a href="login.php" class="btn btn-outline-light btn-lg">Sign In</a>
        </div>
    </div>
    
    <!-- Features Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--dark-violet);">Why Choose Lavender Pharmacy?</h2>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-pills"></i>
                        <h4>Wide Product Range</h4>
                        <p>Access our comprehensive pharmacy product catalog with real-time inventory management.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-lock"></i>
                        <h4>Secure Transactions</h4>
                        <p>Your data is protected with encryption and secure password handling.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-receipt"></i>
                        <h4>Digital Receipts</h4>
                        <p>Get instant, printable receipts for all your purchases with complete transaction details.</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shopping-cart"></i>
                        <h4>Easy Checkout</h4>
                        <p>Simple and intuitive checkout process with multiple payment options.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-bar"></i>
                        <h4>Smart Analytics</h4>
                        <p>Track sales, inventory, and generate comprehensive reports effortlessly.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-users"></i>
                        <h4>Role-Based Access</h4>
                        <p>Different user roles with specific permissions for admin, editors, and customers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-4 text-center">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
            <p>For support, contact: admin@lavenderpharmacy.com | Phone: 09188887673</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

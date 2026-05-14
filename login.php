<?php
require_once 'includes/init.php';

// If already logged in, redirect to appropriate page
if (isLoggedIn()) {
    header('Location: ' . APP_URL . 'index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required';
    } else {
        try {
            $user = User::authenticate($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $user['role'];
                
                showSuccess('Login successful! Redirecting...');
                
                // Redirect based on role
                switch ($user['role']) {
                    case ROLE_ADMIN:
                        header('Location: ' . APP_URL . 'admin/dashboard.php');
                        break;
                    case ROLE_EDITOR:
                        header('Location: ' . APP_URL . 'editor/products.php');
                        break;
                    default:
                        header('Location: ' . APP_URL . 'customer/shop.php');
                }
                exit;
            } else {
                $error = 'Invalid email or password';
            }
        } catch (Exception $e) {
            $error = 'Login error: ' . $e->getMessage();
            logError('Login error', ['email' => $email, 'error' => $e->getMessage()]);
        }
    }
}

$page_title = 'Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --lavender: #B57EDC;
            --soft-purple: #C8A2C8;
            --dark-violet: #5D3A66;
        }
        
        body {
            background: linear-gradient(135deg, #E6E6FA 0%, #C8A2C8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header i {
            color: var(--lavender);
            font-size: 3rem;
            margin-bottom: 10px;
        }
        
        .login-header h1 {
            color: var(--dark-violet);
            font-weight: bold;
            font-size: 1.8rem;
        }
        
        .form-control {
            border-color: #ddd;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--lavender);
            box-shadow: 0 0 0 0.2rem rgba(181, 126, 220, 0.25);
        }
        
        .btn-login {
            background-color: var(--lavender);
            border: none;
            color: white;
            padding: 10px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background-color: var(--dark-violet);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(181, 126, 220, 0.3);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .register-link a {
            color: var(--lavender);
            text-decoration: none;
            font-weight: bold;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-flower"></i>
            <h1>Lavender Pharmacy</h1>
            <p class="text-muted">Sign In to Your Account</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required 
                       placeholder="Enter your email" autocomplete="email">
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required 
                       placeholder="Enter your password" autocomplete="current-password">
            </div>
            
            <button type="submit" class="btn btn-login w-100">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>
        
        <div class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
        
        <div class="text-center mt-3">
            <a href="index.php" class="text-muted" style="text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

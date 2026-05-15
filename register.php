<?php
// Redirect to Laravel register route
header('Location: /register');
exit;

// If already logged in, redirect to appropriate page
if (isLoggedIn()) {
    header('Location: ' . APP_URL . 'index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $contact_number = sanitize($_POST['contact_number'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    
    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Name, email, and password are required';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        try {
            $user = new User();
            $user->register($name, $email, $password, $contact_number, $address, ROLE_CUSTOMER);
            $success = 'Registration successful! Please log in.';
            
            // Redirect to login after 2 seconds
            header('refresh:2;url=' . APP_URL . 'login.php');
        } catch (Exception $e) {
            $error = $e->getMessage();
            logError('Registration error', ['email' => $email, 'error' => $e->getMessage()]);
        }
    }
}

$page_title = 'Register';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?php echo APP_NAME; ?></title>
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
            padding: 40px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .register-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header i {
            color: var(--lavender);
            font-size: 3rem;
            margin-bottom: 10px;
        }
        
        .register-header h1 {
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
        
        .btn-register {
            background-color: var(--lavender);
            border: none;
            color: white;
            padding: 10px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            background-color: var(--dark-violet);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(181, 126, 220, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .login-link a {
            color: var(--lavender);
            text-decoration: none;
            font-weight: bold;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h1>Create Account</h1>
            <p class="text-muted">Join Lavender Pharmacy</p>
        </div>
        
        <?php if ($error): ?>
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
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required 
                       placeholder="Enter your full name">
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required 
                       placeholder="Enter your email">
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required 
                       placeholder="At least 8 characters with letters and numbers">
            </div>
            
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required 
                       placeholder="Confirm your password">
            </div>
            
            <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number (Optional)</label>
                <input type="tel" class="form-control" id="contact_number" name="contact_number" 
                       placeholder="Your phone number">
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">Address (Optional)</label>
                <textarea class="form-control" id="address" name="address" rows="3" 
                          placeholder="Your address"></textarea>
            </div>
            
            <button type="submit" class="btn btn-register w-100">
                <i class="fas fa-user-check"></i> Create Account
            </button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Sign in here</a>
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

<?php
// Redirect to unauthorized route
header('Location: /unauthorized');
exit;

$page_title = 'Unauthorized Access';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #E6E6FA 0%, #C8A2C8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-container {
            background: white;
            border-radius: 15px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 600px;
        }
        
        .error-code {
            font-size: 5rem;
            color: #B57EDC;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .error-title {
            font-size: 2rem;
            color: #5D3A66;
            margin-bottom: 15px;
        }
        
        .error-message {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        
        .btn-home {
            background-color: #B57EDC;
            border: none;
            color: white;
            padding: 12px 30px;
        }
        
        .btn-home:hover {
            background-color: #5D3A66;
            color: white;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">403</div>
        <h1 class="error-title">Access Denied</h1>
        <p class="error-message">
            You do not have permission to access this page. 
            Please contact an administrator if you believe this is an error.
        </p>
        <a href="<?php echo APP_URL; ?>" class="btn btn-home">
            <i class="fas fa-home"></i> Go to Home
        </a>
    </div>
</body>
</html>

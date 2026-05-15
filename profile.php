<?php
// Redirect to Laravel profile route
header('Location: /profile');
exit;

requireLogin();

$user = getCurrentUser();
$page_title = 'My Profile';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = sanitize($_POST['name'] ?? '');
        $contact_number = sanitize($_POST['contact_number'] ?? '');
        $address = sanitize($_POST['address'] ?? '');
        
        if (empty($name)) {
            throw new Exception('Name is required');
        }
        
        $db = Database::getInstance()->getConnection();
        $query = "UPDATE users SET name = ?, contact_number = ?, address = ? WHERE user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssi', $name, $contact_number, $address, $user['user_id']);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to update profile');
        }
        
        $stmt->close();
        showSuccess('Profile updated successfully');
        header('Refresh: 2');
    } catch (Exception $e) {
        showError($e->getMessage());
    }
}
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
            --dark-violet: #5D3A66;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender) 0%, #C8A2C8 100%);
        }
        
        .profile-card {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        
        .btn-update {
            background-color: var(--lavender);
            border: none;
            color: white;
        }
        
        .btn-update:hover {
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
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Messages -->
    <div class="container mt-4">
        <?php if ($error = getError()): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($success = getSuccess()): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Profile Content -->
    <div class="container my-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="profile-card p-4">
                    <h2 class="mb-4" style="color: var(--dark-violet);">
                        <i class="fas fa-user-circle"></i> My Profile
                    </h2>
                    
                    <form method="POST" action="profile.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                            <small class="text-muted">Email cannot be changed</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" id="contact" name="contact_number" 
                                   value="<?php echo htmlspecialchars($user['contact_number'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Account Role</label>
                            <input type="text" class="form-control" value="<?php echo ucfirst($user['role']); ?>" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Member Since</label>
                            <input type="text" class="form-control" value="<?php echo date('F d, Y', strtotime($user['date_created'])); ?>" disabled>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-update">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <a href="<?php echo APP_URL; ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

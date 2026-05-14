<?php
/**
 * Database Configuration File
 * Lavender Pharmacy - Pharmacy Management & E-Commerce System
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lavender_pharmacy');

// Application constants
define('APP_NAME', 'Lavender Pharmacy');
define('APP_URL', 'http://localhost/lavender-pharmacy/');
define('APP_VERSION', '1.0.0');

// Session settings
define('SESSION_TIMEOUT', 1800); // 30 minutes
define('REMEMBER_ME_DURATION', 86400 * 30); // 30 days

// User roles
define('ROLE_ADMIN', 'admin');
define('ROLE_EDITOR', 'editor');
define('ROLE_CUSTOMER', 'customer');

// VAT Rate
define('VAT_RATE', 0.12); // 12% VAT

// Currency
define('CURRENCY', 'PHP');
define('CURRENCY_SYMBOL', '₱');

// Payment Methods
define('PAYMENT_METHODS', ['cash', 'gcash', 'card']);

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('UPLOAD_DIR', dirname(__DIR__) . '/uploads/');

// Email settings (for future use)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('ADMIN_EMAIL', 'admin@lavenderpharmacy.com');

// Timezone
date_default_timezone_set('Asia/Manila');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/logs/error.log');
?>

<?php
/**
 * Common Initialization File
 * Includes all necessary configurations and classes
 */

// Include configuration
require_once dirname(__DIR__) . '/config/db_config.php';

// Include Database class
require_once dirname(__DIR__) . '/classes/Database.php';

// Include User-related classes
require_once dirname(__DIR__) . '/classes/User.php';
require_once dirname(__DIR__) . '/classes/Admin.php';
require_once dirname(__DIR__) . '/classes/Editor.php';
require_once dirname(__DIR__) . '/classes/Customer.php';

// Include business classes
require_once dirname(__DIR__) . '/classes/Product.php';
require_once dirname(__DIR__) . '/classes/Order.php';
require_once dirname(__DIR__) . '/classes/Receipt.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    session_set_cookie_params([
        'lifetime' => SESSION_TIMEOUT,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Function to get current user
function getCurrentUser() {
    if (isLoggedIn()) {
        return User::getUserById($_SESSION['user_id']);
    }
    return null;
}

// Function to check user role
function hasRole($role) {
    if (!isLoggedIn()) {
        return false;
    }
    return $_SESSION['role'] === $role;
}

// Function to require login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . APP_URL . 'login.php');
        exit;
    }
}

// Function to require specific role
function requireRole($role) {
    requireLogin();
    
    if (!hasRole($role)) {
        header('Location: ' . APP_URL . 'unauthorized.php');
        exit;
    }
}

// Function to display error message
function showError($message) {
    $_SESSION['error'] = $message;
}

// Function to display success message
function showSuccess($message) {
    $_SESSION['success'] = $message;
}

// Function to get error message
function getError() {
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
        return $error;
    }
    return null;
}

// Function to get success message
function getSuccess() {
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
        return $success;
    }
    return null;
}

// Function to sanitize input
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(stripslashes($input), ENT_QUOTES, 'UTF-8');
}

// Function to format currency
function formatCurrency($amount) {
    return CURRENCY_SYMBOL . number_format($amount, 2);
}

// Function to log error
function logError($message, $context = []) {
    $log_file = dirname(__DIR__) . '/logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] $message\n";
    
    if (!empty($context)) {
        $log_message .= "Context: " . json_encode($context) . "\n";
    }
    
    if (!is_dir(dirname($log_file))) {
        mkdir(dirname($log_file), 0755, true);
    }
    
    file_put_contents($log_file, $log_message, FILE_APPEND);
}
?>

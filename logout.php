<?php
require_once 'includes/init.php';

// Destroy session
session_destroy();

// Redirect to home
header('Location: ' . APP_URL);
exit;
?>

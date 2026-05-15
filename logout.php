<?php
// Redirect to Laravel logout route
header('Location: /logout', true, 302);
exit;

// Destroy session
session_destroy();

// Redirect to home
header('Location: ' . APP_URL);
exit;
?>

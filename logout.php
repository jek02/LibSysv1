<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Destroy all session data
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>

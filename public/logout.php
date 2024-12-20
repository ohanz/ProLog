<?php
require_once 'config.php';
session_start();

// Destroy the session
session_destroy();

// Unset the session variables
unset($_SESSION['username']);

// Redirect the user to the login page
header('Location: login.php');
exit;
?>
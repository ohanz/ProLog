<?php
require_once 'config.php';
echo "Dashboard page loaded!";

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<html>
<head>
    <title>Ihype | Prolog Home</title>
</head>
<body>
    Welcome to Home, Your Dashboard!
    <?php echo "Welcome, " . $_SESSION['username'] . "!"; ?>
</body>
</html>

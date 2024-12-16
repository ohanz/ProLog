<html>
    <head><title>Ihype | Prolog Home</title></head>
    <body>
        Welcome to Home, Your Dashboard!
        <?php
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

echo "Welcome, " . $_SESSION['username'] . "!";
?>
</body>
</html>
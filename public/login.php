<?php
require_once 'config.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $AliErr = "";

    $stmt = $conn->prepare("SELECT * FROM hypers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            var_dump($_SESSION);
            ob_end_clean();
            header('Location: dashboard.php', true, 302);
            exit;
        } else {
            $AliErr= "Invalid username or password";
        }
    } else {
        $AliErr= "Invalid username or password";
    }
}
# To Avoid Php Error in global variable. Consider placing php-script in body instead.
?>

<html>
    <head>
        <title>Ihype | ProLog Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
<form action="login.php" method="post">
<p><span class="error-not">* Required field!</span></p>
    <p><div class="error"><?php echo $AliErr; ?></div>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" name="login" value="Login Now">
    <a href="signup.php"><input type="button" name="register" value="Sign Up"></a>
</form>
</body>
</html>
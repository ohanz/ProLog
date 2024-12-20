<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $allErr = $nameErr = $emailErr = $passErr = "";

    // Validate user input
    // if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    //     $allErr= '* Please fill in all fields.';
    // } 
    if (empty($username) && empty($email) && empty($password) && empty($confirm_password)) {
        $allErr= '* Please fill in all fields.';
    }
 elseif (empty($username)){
   $nameErr = " * Hyper Name is required.";
}
elseif (empty($email)){
    $emailErr = " * Email is required.";
 }
 elseif (empty($password)){
    $passErr = " * Enter password.";
 }
    elseif ($password != $confirm_password) {
        // echo 'Passwords do not match.';
        $passErr = ' * Passwords do not match.';
    } else {
        // Check if username or email already exists
        $query = "SELECT * FROM hypers WHERE username = '$username' OR email = '$email'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            echo 'Username or email already exists.';
        } else {
            // Hash password and insert user into database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO hypers (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            if ($conn->query($query) === TRUE) {
                echo 'User created successfully.';
            } else {
                echo 'Error creating user.';
            }
        }
    }
}
?>

<html>
    <head>
        <title>Ihype | ProLog Sign Up</title>
        <link rel="stylesheet" href="style.css">
    </head>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<p><span class="error-not">* Required field!</span></p>
<div class="errorHead"><?php echo $allErr;?></div><br/>
    <label for="username">Username:</label>
    <input type="text" id="username" value="<?php if(isset($username)) echo $username; ?>" name="username">
    <span class="error"><?php echo $nameErr;?></span><br><br>
    <label for="email">Email:</label>
    <input type="email" value="<?php if(isset($email)) echo $email; ?>" id="email" name="email">
    <span class="error"><?php echo $emailErr;?></span><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><span class="error"><?php echo $passErr;?></span><br><br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password">
    <br><br>
    <input type="submit" value="Sign Up">
    <a href="login.php"><input type="button" name="logins" value="Login Instead"></a>
</form>
</html>

<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate user input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo 'Please fill in all fields.';
    } elseif ($password != $confirm_password) {
        echo 'Passwords do not match.';
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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password"><br><br>
    <input type="submit" value="Sign Up">
</form>

<!doctype html>
<html>
<head>
<title>Ihype | Prolog Password RESET</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once 'config.php';

if (isset($_GET['token'])) {
  $token = $_GET['token'];

  // Check if token exists in database
  $stmt = $conn->prepare("SELECT * FROM hypers WHERE password_reset_token = ?");
  $stmt->bind_param("s", $token);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Display password reset form
    ?>
    <form action="password-reset.php" method="post">
      <label for="password">New Password:</label>
      <input type="password" id="password" name="password"><br><br>
      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password"><br><br>
      <input type="hidden" name="token" value="<?php echo $token; ?>">
      <input type="submit" name="reset" value="Reset Password">
    </form>
    <?php
  } else {
    echo "Invalid token!";
  }
}

if (isset($_POST['reset'])) {
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm-password'];
  $token = $_POST['token'];

  // Check if passwords match
  if ($password !== $confirm_password) {
    echo "Passwords do not match!";
  } else {
    // Update user's password in database
    $stmt = $conn->prepare("UPDATE hypers SET password = ? WHERE password_reset_token = ?");
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ss", $hashed_password, $token);
    $stmt->execute();

    // Remove password reset token from database
    $stmt = $conn->prepare("UPDATE hypers SET password_reset_token = NULL WHERE password_reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    echo "Password reset successfully!";
  }
}
?>

</body>
</html>

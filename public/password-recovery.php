<?php
require_once 'config.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['recover'])) {
  $email = $_POST['email'];

  // Check if email exists in database
  $stmt = $conn->prepare("SELECT * FROM hypers WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      // Generate password reset token
      $token = bin2hex(random_bytes(16));
      // added expiration-var
      $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));

      // Update user's password reset token in database
      $stmt = $conn->prepare("UPDATE hypers SET password_reset_token = ?, password_reset_token_expires = ? WHERE email = ?");
     $stmt->bind_param("sss", $token, $expires, $email);
      $stmt->execute();

      $stmt = $conn->prepare("SELECT password_reset_token_expires FROM hypers WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $expires = $result->fetch_assoc()['password_reset_token_expires'];
  
      if (strtotime($expires) < time()) {
          echo "Token has expired. Please request a new password recovery token.";
     // Redirect to request new token
     header("Location: password-recovery.php");
     exit;
        } else {
          // Proceed with password reset

      // Send password recovery email
      require '../vendor/autoload.php';
      $mail = new PHPMailer(true);
      try {
          // Server settings
          $mail->SMTPDebug = 0;
          $mail->DebugOutput = '';
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'smtp email';
          $mail->Password = 'smtp pass';
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;

          // Recipients
          $mail->setFrom('your email', 'Ohanz@prolog');
          $mail->addAddress($email);

          // Content
          $mail->isHTML(true);
          $mail->Subject = 'Password Recovery';
          $mail->Body = 'Click the link to reset your password: <a href="http://localhost/ProLog/public/password-reset.php?token=' . $token . '">Reset Password</a>';

          $mail->send();
          echo 'Password recovery email sent!';
      } catch (Exception $e) {
          echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
      }

      }

  } else {
      echo "Email not found!";
  }
}
?>
<html>
    <head>
        <title>Ihype | ProLog Password Recovery</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
<form action="password-recovery.php" method="post">
  <label for="email">Email:</label>
  <input type="email" id="email" name="email"><br><br>
  <input type="submit" name="recover" value="Recover Password">
</form>
</body>
</html>

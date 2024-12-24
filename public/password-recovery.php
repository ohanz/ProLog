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

    // Update user's password reset token in database
    $stmt = $conn->prepare("UPDATE hypers SET password_reset_token = ? WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    // Send password recovery email
    // $to = $email;
    // $subject = "Password Recovery";
    // $message = "Click the link to reset your password: <a href='password-reset.php?token=$token'>Reset Password</a>";
    // $headers = "From: hypercoderd@gmail.com\r\n";
    // mail($to, $subject, $message, $headers);
    // //  your-email@example.com
  //   echo "Password recovery email sent!";
  // } else {
  //   echo "Email not found!";
  // }

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = ''; // SMTP username
    $mail->Password = ''; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    //Recipients
    $mail->setFrom('hypercoderd@gmail.com', 'Ohanz@prolog');
    $mail->addAddress($email); // Add a recipient

    //Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Password Recovery';
    $mail->Body = 'Click the link to reset your password: <a href="password-reset.php?token=' . $token . '">Reset Password</a>';

    $mail->send();
    echo 'Password recovery email sent!';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

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

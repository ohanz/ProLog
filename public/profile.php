<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Retrieve user profile information from database
$stmt = $conn->prepare("SELECT * FROM hypers WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Display user profile information
?>
<html>
<head>
<title>Ihype | Prolog Profile</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<form action="profile.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br><br>
    <input type="submit" name="update" value="Update Profile">
</form>
<br /> <br />
Click Here If <a href="password-recovery.php"><input type="button" value="Forgot Password"></a>
</body>
</html>


<?php
// Update user profile information
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Validate and sanitize user input data
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);

    // Update user profile information in database
    $stmt = $conn->prepare("UPDATE hypers SET username = ?, email = ? WHERE username = ?");
    $stmt->bind_param("sss", $username, $email, $_SESSION['username']);
    $stmt->execute();

    // Display success message
    echo "Profile updated successfully!";
}
?>
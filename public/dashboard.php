<?php
require_once 'config.php';
ob_start();
session_start(); // resolved session bug

 $hyper = $_SESSION['username'];
if(isset($hyper) == null || empty($hyper)){
 echo "<br/>"."[Hype error: Null session rectrieved]"."<br/>"."<br/>";
//  $hyper = "<b>"."Hyper def"."</b>";
 
//  header('Location: login.php');
//  exit;
}
else{
      echo 'Eloo Success!';
}

ob_end_flush();
?>

<html>
<head>
<title>Ihype | Prolog Home</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="bodyy">
Welcome to Home, Your Dashboard!
<?php
echo "<br/>"."<br/>"."Dashboard Page Loaded! ";
if(isset($hyper)){
echo "Welcome, "."<b>" . $hyper . "!"."</b>";
}
else{
 echo "<b>"."YOU'RE NOT LOGGED IN!";
}

?>

<footer>Bored? <a href="logout.php">Logout Here!</a></footer>
</body>
</html>
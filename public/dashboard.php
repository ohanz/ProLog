<?php
require_once 'config.php';
ob_start();
session_start(); // resolved session bug

 $hyper = $_SESSION['username'];
if(isset($hyper) == null){
 echo "<br/>"."[Hype error: Null session rectrieved]"."<br/>"."<br/>";
 $hyper = "<b>"."Hyper def"."</b>";
 
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
</head>
<body>
Welcome to Home, Your Dashboard!
<?php
echo "<br/>"."<br/>"."Dashboard Page Loaded! ";
echo "Welcome, "."<b>" . $hyper . "!"."</b>";
?>
</body>
</html>
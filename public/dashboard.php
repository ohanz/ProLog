<?php
require_once 'config.php';
ob_start();

 $hyper = $_SESSION['username'];
if(isset($hyper) == null){
 echo "<br/>"."[Hype error: Null session rectrieved]"."<br/>"."<br/>";
 $hyper = "<b>"."Hyper def"."</b>";
}
else{
      echo 'Eloo';
}
// if (isset($_SESSION['username'])) {
//     echo 'Eloo';
// }
// else{
//     // header('Location: login.php');
//     // exit;
// }

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
echo "Welcome, " . $hyper . "!";
?>
</body>
</html>
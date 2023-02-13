<html>
 
<head><title>CSCI466 404 Brain Not Found Karaoke Project</title></head>
 
<body>
<h1>It's Karaoke Time!</h1>
 
<?php
include('secrets.php');
 
try{
$dsn="mysql:host=courses; dbname=$username";
$pdo=new PDO($dsn, $username, $password);
}
 
catch(PDOexception $e){
echo "Connection to database failed" . $e->getMessage();
}
 
echo "<h2>Please Enter a Song, Artist, or Contributor</h2>";
echo "<form method='POST' action='http://students.cs.niu.edu/~z1900146/group2.php'>";
echo "<input type='text' name='UserSearch'/>";
echo "<input type='submit'/>";
echo "</form>";
 
?>
 
</html>


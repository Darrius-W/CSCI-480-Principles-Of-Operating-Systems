<html>
 
<head><title>CSCI466 404 Brain Not Found Karaoke Project</title></head>
 
<body>
 
<?php
include('secrets.php');
 
try{
$dsn="mysql:host=courses; dbname=$username";
$pdo=new PDO($dsn, $username, $password);
}
 
catch(PDOexception $e){
echo "Connection to database failed" . $e->getMessage();
}
 
 
 
 
echo "<h2>Please Pick a Version</h2>";
 
if(isset($_POST['songid']))
{
$prep = $pdo->prepare("SELECT Song.ARTISTNAME, Song.TITLE, KaraokeFile.VERSION, KaraokeFile.KARAOKEID FROM KaraokeFile, Song WHERE KaraokeFile.SONGID=? AND KaraokeFile.SONGID=Song.SONGID");
$prep->execute(array($_POST['songid']));
$rows = $prep->fetchAll(PDO::FETCH_ASSOC);
 
echo "<table border=1>";
echo "<tr><th>Artist</th><th>Title</th><th>Version</th></tr>";
echo "<form method='POST' action='http://students.cs.niu.edu/~z1900146/group4.php'>";
 
foreach($rows as $z=>$x)
   {
   echo "<tr>";
   foreach($x as $z2=>$x2)
      {
      echo "<td>";
      echo "$x2";
      echo "</td>";
      }
   echo "<td><input type='radio' name='versionid' value='$x2'></td>";
   echo "</tr>";
   }
 
 
echo "</table>";
}
 
 
echo "<h3>Your Name:</h3>";
echo "<form method='POST' action='http://students.cs.niu.edu/~z1900146/group4.php'>";
echo "<input type='text' name='uname'/>";
 
echo "<h3>Add song to:</h3>";
echo "<input type='radio' name='queuetype' value='free'/> Free Queue <br>";
echo "<input type='radio' name='queuetype' value='paid'/> Paid Queue <br>";
 
echo "<h3>Amount Paid:</h3>";
echo "<input type='text' name='pricepaid'/><br><br>";
echo "<input type='submit'/>";
echo "</form>";
 
 
 
?>
 
</body>
 
</html>


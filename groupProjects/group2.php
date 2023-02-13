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
 
 
 
 
echo "<h3>Artist Search</h3>";
$prep = $pdo->prepare("SELECT Song.ARTISTNAME, Song.TITLE, Contributor.CONTNAME, Contributor.CONTTYPE, Song.SONGID FROM Song, Contributor, Contributes WHERE Song.SONGID=Contributes.SONGID AND Contributor.CONTTYPE=Contributes.CONTTYPE AND Contributor.CONTID=Contributes.CONTID AND Song.ARTISTNAME=?");
$prep->execute(array($_POST['UserSearch']));
$rows = $prep->fetchAll(PDO::FETCH_ASSOC);
 
$sortBy = (isset($_POST['sortBy']) ? $_POST['sortBy'] : NULL);
$sql = 'SELECT Song.ARTISTNAME, Song.TITLE, Contributor.CONTNAME, Contributor.CONTTYPE, Song.SONGID FROM Song, Contributor, Contributes WHERE Song.SONGID=Contributes.SONGID AND Contributor.CONTTYPE=Contributes.CONTTYPE AND Contributor.CONTID=Contributes.CONTID AND Song.ARTISTNAME=?';
if($sortBy != NULL) {
  $sql .= ' ORDER BY ' . $sortBy;
}
if(mysql_num_rows($rows) > 0) {
  echo '<table><tr><th>TITLE</th></tr>';
  while($row = mysqli_fetch_array($result)) {
    echo '<tr><td>' . $rows['TITLE'] . '</td></tr>';
  }
  echo'</table>';
}
?>

<form>
<select name="sortBy">
<option value="TITLE">TITLE</option>
</select>
<button type="submit" action="?" method="POST">submit</button>
</form>
<?php

 
 
 
echo "<h3>Song Search</h3>";
$prep = $pdo->prepare("SELECT Song.TITLE, Song.ARTISTNAME, Contributor.CONTNAME, Contributor.CONTTYPE, Song.SONGID FROM Song, Contributor, Contributes WHERE Song.SONGID=Contributes.SONGID AND Contributor.CONTTYPE=Contributes.CONTTYPE AND Contributor.CONTID=Contributes.CONTID AND Song.TITLE=?");
$prep->execute(array($_POST['UserSearch']));
$rows = $prep->fetchAll(PDO::FETCH_ASSOC);
 
echo "<table border=1>";
echo "<tr><th>Title</th><th>Artist</th><th>Contributor</th><th>Contribution Type</th></tr>";
echo "<form method='POST' action='http://students.cs.niu.edu/~z1900146/group3.php'>";
 
foreach($rows as $z=>$x)
   {
   echo "<tr>";
   foreach($x as $z2=>$x2)
      {
      echo "<td>";
      echo "$x2";
      echo "</td>";
      }
   echo "<td><input type='radio' name='songid' value='$x2'></td>";
   echo "</tr>";
   }
 
echo "</table>";
 
 
 
echo "<h3>Contributor Search</h3>";
$prep = $pdo->prepare("SELECT Contributor.CONTNAME, Contributor.CONTTYPE, Song.ARTISTNAME, Song.TITLE, Song.SONGID FROM Song, Contributor, Contributes WHERE Song.SONGID=Contributes.SONGID AND Contributor.CONTTYPE=Contributes.CONTTYPE AND Contributor.CONTID=Contributes.CONTID AND Contributor.CONTNAME=?");
$prep->execute(array($_POST['UserSearch']));
$rows = $prep->fetchAll(PDO::FETCH_ASSOC);
echo "<table border=1>";
echo "<tr><th>Contributor</th><th>Contribution Type</th><th>Artist</th><th>Title</th></tr>";
echo "<form method='POST' action='http://students.cs.niu.edu/~z1900146/group3.php'>";
 
foreach($rows as $z=>$x)
   {
   echo "<tr>";
   foreach($x as $z2=>$x2)
      {
      echo "<td>";
      echo "$x2";
      echo "</td>";
      }
   echo "<td><input type='radio' name='songid' value='$x2'></td>";
   echo "</tr>";
   }
 
echo "</table>";
 
echo "<input type='submit'/>";
 
 
?>
 
</html>


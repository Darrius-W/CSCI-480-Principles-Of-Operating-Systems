<html><head><title>x</title></head><body><pre>
<?php
error_reporting(E_ALL);

include('secrets.php');
include('library.php');

//connecting to database
try { // if something goes wrong, an exception is thrown
  $dsn = "mysql:host=courses;dbname=z1900146";
  $pdo = new PDO($dsn, $username, $password);

  //sets error alert type
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  //Calling supplier table
  $S_tab = $pdo->query("SELECT * FROM S;");
  $P_tab = $pdo->query("SELECT * FROM P;");
  //echo gettype($S_tab);

  $rows = $S_tab->fetchall(PDO::FETCH_ASSOC);
  echo "<h>Supplier Details</h>";
  draw_table($rows);
  echo "\n\n";

  echo "<h>Parts Details</h>";
  $rows = $P_tab->fetchall(PDO::FETCH_ASSOC);
  draw_table($rows);
  echo "\n\n";

//drop down menu
echo "<h>Select part for deatails</h>";
echo "<form action='http://students.cs.niu.edu/~z035690/submission.php' method='GET'>";
echo "<select name='select' id='select'>";

foreach($rows as $row){
  foreach($row as $key => $item){
    if($key == "PNAME"){
    echo "<option name='part' value='$item'>$item";
    echo "</option>";
    }
  }
}
echo "</select>";
//echo "<input type='submit' name='Submit'/>";


$prepared = $pdo->prepare('SELECT P FROM P WHERE PNAME = :PNAME');
$prepared->bindParam(':PNAME', $item);
//$prepared->execute(array($item));
$prepared->execute();
$part = $prepared->fetchAll();


/*$sql = "SELECT * FROM P WHERE PNAME = :PNAME;";
$prepared = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_DWDONLY));
$success = $prepared->excute(array(':PNAME' => $item));*/
echo "<input type='submit' name='Submit'/>";

echo "</form>";

//}

}
catch(PDOexception $e) { // handle that exception
  echo "Connection to database failed: " . $e->getMessage();
}

?>
</pre></body></html>

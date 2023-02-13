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
 
 
if(isset($_POST['uname']))
   {
   if(empty($_POST['uname']))
      {
      $_POST['uname']='No Name';
      }
   $prepared = $pdo->prepare("INSERT INTO User VALUES (?)");
   $prepared->execute(array($_POST['uname']));
   }
 
 
 
if(isset($_POST['queuetype']))
   {
if(isset($_POST['versionid']))
{
if(empty($_POST['pricepaid']))
         $_POST['pricepaid']=0;
   if($_POST['queuetype']=='free')
      {
      echo "Song added to free queue";
      $prepared = $pdo->prepare("INSERT INTO Selection VALUES (?, ?, ?, '0.00', NOW())");
      $prepared->execute(array($_POST['uname'],$_POST['queuetype'],$_POST['versionid']));
      }
   else
      {
      echo "Song added to paid queue";
      $prepared = $pdo->prepare("INSERT INTO Selection VALUES (?, ?, ?, ?, NOW())");
      $prepared->execute(array($_POST['uname'],$_POST['queuetype'],$_POST['versionid'],$_POST['pricepaid']));
      }
   }
else
   echo "Please go back and select a version";
}
else
   echo "Please go back and enter a queue type";
 
?>
 
</body>
 
</html>


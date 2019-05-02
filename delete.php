<?php
session_start();

require_once("pdo.php");

if( ! isset($_SESSION["name"]) ){
  die("ACCESS DENIED");
}

if( isset($_POST["confirmed"]) ){
  $sql = "DELETE FROM autos WHERE autos_id = :autos_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':autos_id'=>$_GET["autos_id"]));

  $_SESSION["success"] = "Record deleted";
  header("Location: index.php");
  return;
}

if( ! isset($_GET["autos_id"]) ){
  $_SESSION["error"] = "Bad value for id";
  header("Location: index.php");
  return;
}

$sql = "SELECT make FROM autos WHERE autos_id = :autos_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':autos_id'=>$_GET["autos_id"]));

if( $stmt->rowCount() == 0 ){
  $_SESSION["error"] = "Bad value for id";
  header("Location: index.php");
  return;
}

$make = $stmt->fetch(PDO::FETCH_ASSOC)["make"];

?>

<!DOCTYPE html>
<html>
<head>
  <title>A. shafey's CRUD</title>
</head>
<body>

<p>confirm: Deleting <?php echo(htmlentities($make)); ?></p>

<form method="post">
  <input type="submit" value="Delete" name="confirmed">
  <a href="index.php" style="padding: 1em;">Cancel</a>
</form>

</body>
</htlm>

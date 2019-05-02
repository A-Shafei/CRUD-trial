<?php
session_start();

require_once("pdo.php");

if( ! isset($_SESSION["name"]) ){
  die("ACCESS DENIED");
}

if( isset($_POST["cancel"]) ){
  header("Location: index.php");
  return;
}

if( isset($_POST["make"]) && isset($_POST["model"]) && isset($_POST["year"]) && isset($_POST["mileage"]) ){

  if( $_POST["make"] == "" || $_POST["model"] == "" || $_POST["year"] == "" || $_POST["mileage"] == "" ){
    $_SESSION["error"] = "All fields are required";
    header("Location: edit.php?autos_id=".$_GET["autos_id"]);
    return;
  }

  if( ! is_numeric($_POST["year"]) ){
    $_SESSION["error"] = "Year must be an integer";
    header("Location: edit.php?autos_id=".$_GET["autos_id"]);
    return;
  }

  if( ! is_numeric($_POST["mileage"]) ){
    $_SESSION["error"] = "Mileage must be an integer";
    header("Location: edit.php?autos_id=".$_GET["autos_id"]);
    return;
  }

  $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE autos_id = :autos_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':make'=>$_POST["make"], ':model'=>$_POST["model"], ':year'=>$_POST["year"], ':mileage'=>$_POST["mileage"], ':autos_id'=>$_GET["autos_id"]));
  $_SESSION["success"] = "Record edited";
  header("Location: index.php");
  return;

}

if( ! isset($_GET["autos_id"]) ){
  $_SESSION["error"] = "Bad value for id";
  header("Location: index.php");
  return;
}

$sql = "SELECT make, model, year, mileage FROM autos WHERE autos_id = :autos_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':autos_id'=>$_GET["autos_id"]));

if( $stmt->rowCount() == 0 ){
  $_SESSION["error"] = "Bad value for id";
  header("Location: index.php");
  return;
}

$auto_data = $stmt->fetch(PDO::FETCH_ASSOC);

$make = $auto_data["make"];
$model = $auto_data["model"];
$year = $auto_data["year"];
$mileage = $auto_data["mileage"];
?>

<!DOCTYPE html>
<html>
<head>
  <title>A. shafey's CRUD</title>
</head>
<body>

  <h1>Editing Automobile</h1>

  <?php
  if( isset($_SESSION['error']) ){
    echo('<p style="color: RED">'.$_SESSION['error']."</p>\n");
    unset($_SESSION['error']);
  }
  ?>

  <form method="post">
    Make: <input type="text" name="make" value=<?php echo(htmlentities($make)); ?>><br><br>
    Model: <input type="text" name="model" value=<?php echo(htmlentities($model)); ?>><br><br>
    Year: <input type="text" name="year" value=<?php echo(htmlentities($year)); ?>><br><br>
    Mileage: <input type="text" name="mileage" value=<?php echo(htmlentities($mileage)); ?>><br><br>
    <input type="submit" value="Save">
    <input type="submit" name="cancel" value="Cancel">
  </form>

</body>
</htlm>

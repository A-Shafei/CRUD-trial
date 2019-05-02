<?php
session_start();

require_once("pdo.php");

if( ! isset($_SESSION["name"]) ){
  die("ACCESS DENIED");
}

$email = $_SESSION['name'];

if( isset($_POST["cancel"]) ){
  header("Location: index.php");
  return;
}

if( isset($_POST["make"]) && isset($_POST["model"]) && isset($_POST["year"]) && isset($_POST["mileage"]) ){

  if( $_POST["make"] == "" || $_POST["model"] == "" || $_POST["year"] == "" || $_POST["mileage"] == "" ){
    $_SESSION["error"] = "All fields are required";
    header("Location: add.php");
    return;
  }

  if( ! is_numeric($_POST["year"]) ){
    $_SESSION["error"] = "Year must be an integer";
    header("Location: add.php");
    return;
  }

  if( ! is_numeric($_POST["mileage"]) ){
    $_SESSION["error"] = "Mileage must be an integer";
    header("Location: add.php");
    return;
  }

  $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:make, :model, :year, :mileage)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':make'=>$_POST["make"], ':model'=>$_POST["model"], ':year'=>$_POST["year"], ':mileage'=>$_POST["mileage"]));
  $_SESSION["success"] = "Record added";
  header("Location: index.php");
  return;

}

?>

<!DOCTYPE html>
<html>
<head>
  <title>A. shafey's CRUD</title>
</head>
<body>

<h1>Adding Automobiles for <?php echo(htmlentities($email)) ?></h1>

<?php
if( isset($_SESSION["error"]) ){
  echo('<p style="color: RED;">'.$_SESSION["error"]."</p>\n");
  unset($_SESSION["error"]);
}
?>

<form method="post">
  Make: <input type="text" name="make"><br><br>
  Model: <input type="text" name="model"><br><br>
  Year: <input type="text" name="year"><br><br>
  Mileage: <input type="text" name="mileage"><br><br>
  <input type="submit" value="Add">
  <input type="submit" name="cancel" value="Cancel">
</form>

</body>
</htlm>

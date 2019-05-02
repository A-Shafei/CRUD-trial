<?php
session_start();

require_once("pdo.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>A. shafey's CRUD</title>
</head>
<body>

<?php

if( ! isset($_SESSION["name"]) ){
  echo "<h1>Welcome to the Automobiles Database</h1>";
  echo "<a href='login.php'>Please log in</a>";
}

if( isset($_SESSION["name"]) ){

  echo "<h1>Welcome to the Automobiles Database</h1>";

  if( isset($_SESSION['success']) ){
    echo('<p style="color: GREEN">'.$_SESSION['success']."</p>\n");
    unset($_SESSION['success']);
  }

  if( isset($_SESSION['error']) ){
    echo('<p style="color: RED">'.$_SESSION['error']."</p>\n");
    unset($_SESSION['error']);
  }

  $stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");

  if( $stmt->rowCount() == 0 ){
    echo("<p>No rows found</p>");
  }
  else{
    echo("<table style='border-collapse: collapse;'>");

    echo("<tr>");
    echo("<th style='padding: 5px; border: 1px solid;'>Make</th>");
    echo("<th style='padding: 5px; border: 1px solid;'>Model</th>");
    echo("<th style='padding: 5px; border: 1px solid;'>Year</th>");
    echo("<th style='padding: 5px; border: 1px solid;'>Mileage</th>");
    echo("<th style='padding: 5px; border: 1px solid;'>Action</th>");
    echo("</tr>");

    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
      echo("<tr>");
      echo("<td style='padding: 5px; text-align: center; border: 1px solid;'>".$row["make"]."</td>");
      echo("<td style='padding: 5px; text-align: center; border: 1px solid;'>".$row["model"]."</td>");
      echo("<td style='padding: 5px; text-align: center; border: 1px solid;'>".$row["year"]."</td>");
      echo("<td style='padding: 5px; text-align: center; border: 1px solid;'>".$row["mileage"]."</td>");
      echo("<td style='padding: 5px; text-align: center; border: 1px solid;'><a href='edit.php?autos_id=".$row["autos_id"]."'>Edit</a> / <a href='delete.php?autos_id=".$row["autos_id"]."'>Delete</a></td>");
      echo("</tr>");
    }

    echo("</table><br>");
  }

  echo "<a href='add.php'>Add New Entry</a><br><br>";
  echo "<a href='logout.php'>Logout</a>";

}

 ?>

</body>
</htlm>

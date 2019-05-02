<?php
session_start();

if( isset($_POST["email"]) && isset($_POST["pass"]) ){

  $email = $_POST["email"];
  $pass = $_POST["pass"];
  $salt = 'XyZzy12*_';
  $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
  $check = hash("md5", $salt.$pass);

  if( $email == "" || $pass == "" ){
    $_SESSION['error'] = "User name and password are required";
    header("Location: login.php");
    return;
  }

  if( $check != $stored_hash ){
    $_SESSION['error'] = "Incorrect password";
    header("Location: login.php");
    return;
  }

  if( $check === $stored_hash ){
    $_SESSION['name'] = $email;
    header("Location: index.php");
    return;
  }

}

 ?>

<!DOCTYPE html>
<html>
<head>
  <title>A. shafey's CRUD</title>
</head>
<body>

<h1>Please log in</h1>

<?php

if( isset($_SESSION['error']) ){
  echo('<p style="color: RED">'.$_SESSION['error']."</p>\n");
  unset($_SESSION['error']);
}

?>

<form method="post">
  User Name <input type="text" name="email"><br>
  Password <input type="text" name="pass"><br>
  <input type="submit" value="Log In">
  <a href="index.php">Cancel</a>
</form>

</body>
</html>

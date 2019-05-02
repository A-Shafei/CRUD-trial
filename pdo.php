<?php
$pdo = new PDO('mysql:host=localhost; port=3307; dbname=misc', 'shafey', '123sql321');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<?php
 $hostdb = "127.0.0.1"; 
 $user = "root";
 $pass = "";
 $dbname = "home";
 $mysqli = new mysqli($hostdb, $user, $pass, $dbname);
 if($mysqli->connect_error) {
  exit('Error connecting to database!');
 }
?>
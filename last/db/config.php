<?php
$host = "localhost";
$username = "root";
$password = "Tejas@17";
$database = "mcq_test"; // Make sure this matches your DB name in phpMyAdmin

$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>

<?php 
$server = "localhost";
$user= "root";
$password = "root";
$dbname = "ethol";
$conn = mysqli_connect($server, $user, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

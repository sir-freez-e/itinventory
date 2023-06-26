<?php
$servername = "localhost";
$username = "itadmin";
$password = "Monday01";
$dbname = "database";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

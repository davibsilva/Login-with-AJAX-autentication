<?php
$serverName = "localhost";
$username = "root";
$password = "123456";
$database = "users";

$conn = mysqli_connect($serverName, $username, $password, $database);


if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
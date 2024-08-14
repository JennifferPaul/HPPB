<?php

// Database connection settings
$host = "localhost";
$username = "root";
$password = "panda";
$database = "sys";

// Establishing connection to MySQL
$con = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Successfully connected to the database.";
}
?>

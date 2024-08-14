<?php
// Include config.php from the parent directory
include("config.php");

// Function to verify agent credentials
function verifyAgentCredentials($email, $password) {
    global $con; // Assuming $con is your database connection

    // Escape inputs to prevent SQL injection
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    // Hash the password (if necessary, based on your database schema)
    $password = sha1($password); // Update this according to your actual hashing method

    // Query to fetch user details by email and password
    $query = "SELECT * FROM user WHERE uemail='$email' AND upass='$password' AND utype='agent'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        // Agent found, return true
        return true;
    } else {
        // Agent not found or credentials don't match
        return false;
    }
}
?>

<?php
// filter_properties.php

header('Content-Type: text/html; charset=utf-8');

ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");

// Assume speech input is sent as JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['spokenText'])) {
    $spokenText = $data['spokenText'];

    // Process $spokenText to determine filter criteria
    // Example: Extract type, subtype, city from spoken text input

    // Construct SQL query based on filter criteria
    $sql = "SELECT property.*, user.uname FROM `property`,`user` WHERE property.uid=user.uid AND type='apartment' AND city='New York'";

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $properties = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $properties[] = $row;
        }
        foreach ($properties as $property) {
            echo "<li>{$property['title']}</li>"; // Adjust this according to your property data structure
        }
    } else {
        echo '<li>No properties found.</li>';
    }
} else {
    echo '<li>Invalid input.</li>';
}
?>

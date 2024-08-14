<?php
// process_speech.php

header('Content-Type: application/json');

ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");

// Assume speech input is sent as JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['speechInput'])) {
    $speechInput = $data['speechInput'];

    // Process $speechInput to determine filter criteria
    // Example: Extract type, subtype, city from speech input

    // Construct SQL query based on filter criteria
    $sql = "SELECT property.*, user.uname FROM `property`,`user` WHERE property.uid=user.uid AND type='apartment' AND city='New York'";

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $properties = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $properties[] = $row;
        }
        echo json_encode($properties);
    } else {
        echo json_encode(['error' => 'No properties found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid input.']);
}
?>

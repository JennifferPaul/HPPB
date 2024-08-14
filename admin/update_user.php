<?php
include("../config.php"); // Include config.php from the parent directory

// Ensure the user is logged in and is an agent
session_start();
if (!isset($_SESSION['uid']) || $_SESSION['utype'] !== 'agent') {
    echo "Unauthorized access.";
    exit;
}

// Get the logged-in agent's ID from the session
$loggedInAgentId = $_SESSION['uid'];
$userIdToManage = $_POST['uid']; // The user's ID to be managed

// Check if the logged-in agent is authorized to manage the user
$query = "SELECT * FROM user WHERE uid = '$userIdToManage' AND agentId = '$loggedInAgentId'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    // Agent is authorized to manage this user
    $newData = $_POST['newData']; // This should be sanitized and validated
    $updateQuery = "UPDATE user SET column_name = '$newData' WHERE uid = '$userIdToManage'";
    if (mysqli_query($con, $updateQuery)) {
        echo "Update successful!";
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($con);
    }
} else {
    // Agent is not authorized to manage this user
    echo "You are not authorized to manage this user.";
}

// Close connection
mysqli_close($con);
?>

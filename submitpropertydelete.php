<?php
include("config.php");
$pid = $_GET['id'];

// Start a transaction
mysqli_begin_transaction($con);

try {
    // Delete related bookings first
    $sqlBookings = "DELETE FROM bookings WHERE pid = {$pid}";
    mysqli_query($con, $sqlBookings);

    // Now delete the property
    $sqlProperty = "DELETE FROM property WHERE pid = {$pid}";
    $result = mysqli_query($con, $sqlProperty);

    if ($result) {
        mysqli_commit($con);
        $msg = "<p class='alert alert-success'>Property Deleted</p>";
    } else {
        mysqli_rollback($con);
        $msg = "<p class='alert alert-warning'>Property Not Deleted</p>";
    }
} catch (Exception $e) {
    mysqli_rollback($con);
    $msg = "<p class='alert alert-warning'>Property Not Deleted: " . $e->getMessage() . "</p>";
}

header("Location: feature.php?msg=" . urlencode($msg));
mysqli_close($con);
?>

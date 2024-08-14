<?php
include("config.php");

if (isset($_GET['id'])) {
    $pid = $_GET['id'];

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Fetch title from property table for comparison
        $fetch_title_sql = "SELECT title FROM property WHERE pid = {$pid}";
        $fetch_title_result = mysqli_query($con, $fetch_title_sql);
        if (!$fetch_title_result) {
            throw new Exception("Error fetching title from property table: " . mysqli_error($con));
        }
        $row = mysqli_fetch_assoc($fetch_title_result);
        $title = $row['title'];

        // Delete from bookings table
        $sql1 = "DELETE FROM bookings WHERE pid = {$pid}";
        $result1 = mysqli_query($con, $sql1);
        if (!$result1) {
            throw new Exception("Error deleting from bookings table: " . mysqli_error($con));
        }

        // Delete from property table
        $sql2 = "DELETE FROM property WHERE pid = {$pid}";
        $result2 = mysqli_query($con, $sql2);
        if (!$result2) {
            throw new Exception("Error deleting from property table: " . mysqli_error($con));
        }

        // Delete from permanent_property table where title matches
        $sql3 = "DELETE FROM permanent_property WHERE title = '{$title}'";
        $result3 = mysqli_query($con, $sql3);
        if (!$result3) {
            throw new Exception("Error deleting from permanent_property table: " . mysqli_error($con));
        }

        // Commit the transaction
        mysqli_commit($con);

        $msg = "<p class='alert alert-success'>Property Deleted Successfully from all tables</p>";
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        mysqli_rollback($con);
        $msg = "<p class='alert alert-warning'>" . $e->getMessage() . "</p>";
    }

    // Redirect back to propertyview.php with a message
    header("Location: propertyview.php?msg=" . urlencode($msg));
    exit();
} else {
    $msg = "<p class='alert alert-warning'>Invalid Property ID</p>";
    header("Location: propertyview.php?msg=" . urlencode($msg));
    exit();
}

mysqli_close($con);
?>

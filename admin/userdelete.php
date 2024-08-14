<?php
include("config.php");
$uid = $_GET['id'];

// Delete user from user table
$msg = "";
$sql = "DELETE FROM user WHERE uid = {$uid}";
$result = mysqli_query($con, $sql);

if ($result) {
    // Check if user exists in permanent_user table and delete if found
    $check_sql = "SELECT * FROM permanent_user WHERE uid = {$uid}";
    $check_result = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $delete_perm_sql = "DELETE FROM permanent_user WHERE uid = {$uid}";
        $delete_perm_result = mysqli_query($con, $delete_perm_sql);

        if ($delete_perm_result) {
            $msg = "<p class='alert alert-success'>User Deleted from both tables</p>";
        } else {
            $msg = "<p class='alert alert-warning'>User not Deleted from permanent_user table: " . mysqli_error($con) . "</p>";
        }
    } else {
        $msg = "<p class='alert alert-info'>User not found in permanent_user table</p>";
    }

    header("Location:userlist.php?msg=" . urlencode($msg));
} else {
    $msg = "<p class='alert alert-danger'>User not Deleted from user table: " . mysqli_error($con) . "</p>";
    header("Location:userlist.php?msg=" . urlencode($msg));
}

mysqli_close($con);
?>

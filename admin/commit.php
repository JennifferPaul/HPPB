<?php
// Include config.php to establish database connection
include_once 'config.php';

// Check if the connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id']; // Get the ID from the URL parameter

// Prepare the query to fetch data from the user table based on $id
$stmt = $con->prepare("SELECT * FROM `user` WHERE uid = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $row = $result->fetch_assoc();
    if ($row) {
        // Check if the user already exists in permanent_user table
        $check_stmt = $con->prepare("SELECT * FROM permanent_user WHERE uid = ?");
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // User already exists in permanent_user table, update the record
            $update_stmt = $con->prepare("UPDATE permanent_user SET uname = ?, uemail = ?, uphone = ?, upass = ?, utype = ?, uimage = ? WHERE uid = ?");
            $update_stmt->bind_param("ssssssi", $row['uname'], $row['uemail'], $row['uphone'], $row['upass'], $row['utype'], $row['uimage'], $id);
            $update_result = $update_stmt->execute();

            if ($update_result) {
                echo "<p class='alert alert-success'>Data Updated Successfully</p>";
            } else {
                echo "<p class='alert alert-danger'>Error updating record: " . $con->error . "</p>";
            }
        } else {
            // Insert data into permanent_user table if not exists
            $insert_stmt = $con->prepare("INSERT INTO permanent_user (uid, uname, uemail, uphone, upass, utype, uimage) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("issssss", $id, $row['uname'], $row['uemail'], $row['uphone'], $row['upass'], $row['utype'], $row['uimage']);
            $insert_result = $insert_stmt->execute();

            if ($insert_result) {
                echo "<p class='alert alert-success'>Data Inserted Successfully</p>";
            } else {
                echo "<p class='alert alert-danger'>Error inserting into permanent_user table: " . $con->error . "</p>";
            }
        }

        // Optional: update the original user table to set the committed flag
        $update_user_stmt = $con->prepare("UPDATE `user` SET committed = 1 WHERE uid = ?");
        $update_user_stmt->bind_param("i", $id);
        $update_user_stmt->execute();
    } else {
        echo "<p class='alert alert-danger'>No user found with the given ID.</p>";
    }
} else {
    echo "<p class='alert alert-danger'>Error fetching data: " . $con->error . "</p>";
}

// Close database connection
$con->close();

// Redirect back to user list page
header("Location: userlist.php");
exit();
?>

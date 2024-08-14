<?php
// Include config.php to establish database connection
include_once 'config.php';

// Check if the connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id']; // Get the ID from the URL parameter

// Prepare the query to fetch data from the property table based on $id
$stmt = $con->prepare("SELECT * FROM property WHERE pid = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $row = $result->fetch_assoc();
    if ($row) {
        // Check if the property already exists in permanent_property table
        $check_stmt = $con->prepare("SELECT * FROM permanent_property WHERE pid = ?");
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Property already exists in permanent_property table, update the record
            $update_stmt = $con->prepare("UPDATE permanent_property SET title = ?, type = ?, bhk = ?, stype = ?, bedroom = ?, bathroom = ?, balcony = ?, kitchen = ?, hall = ?, floor = ?, size = ?, price = ?, location = ?, city = ?, state = ?, feature = ?, pimage = ? WHERE pid = ?");
            $update_stmt->bind_param("ssssssssssssssssi", $row['title'], $row['type'], $row['bhk'], $row['stype'], $row['bedroom'], $row['bathroom'], $row['balcony'], $row['kitchen'], $row['hall'], $row['floor'], $row['size'], $row['price'], $row['location'], $row['city'], $row['state'], $row['feature'], $row['pimage'], $id);
            $update_result = $update_stmt->execute();

            if ($update_result) {
                echo "<p class='alert alert-success'>Data Updated Successfully</p>";
            } else {
                echo "<p class='alert alert-danger'>Error updating record: " . $con->error . "</p>";
            }
        } else {
            // Insert data into permanent_property table if not exists
            $insert_stmt = $con->prepare("INSERT INTO permanent_property (pid, title, type, bhk, stype, bedroom, bathroom, balcony, kitchen, hall, floor, size, price, location, city, state, feature, pimage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("isssssssssssssssss", $id, $row['title'], $row['type'], $row['bhk'], $row['stype'], $row['bedroom'], $row['bathroom'], $row['balcony'], $row['kitchen'], $row['hall'], $row['floor'], $row['size'], $row['price'], $row['location'], $row['city'], $row['state'], $row['feature'], $row['pimage']);
            $insert_result = $insert_stmt->execute();

            if ($insert_result) {
                echo "<p class='alert alert-success'>Data Inserted Successfully</p>";
            } else {
                echo "<p class='alert alert-danger'>Error inserting into permanent_property table: " . $con->error . "</p>";
            }
        }

        // Optional: update the original property table to set the committed flag
        $update_property_stmt = $con->prepare("UPDATE property SET status = 'committed' WHERE pid = ?");
        $update_property_stmt->bind_param("i", $id);
        $update_property_stmt->execute();
    } else {
        echo "<p class='alert alert-danger'>No property found with the given ID.</p>";
    }
} else {
    echo "<p class='alert alert-danger'>Error fetching data: " . $con->error . "</p>";
}

// Close database connection
$con->close();

// Redirect back to property list page
header("Location: propertylist.php");
exit();
?>

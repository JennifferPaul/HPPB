<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pid = $_POST['pid'];
    $uid = $_POST['uid'];
    $uname = $_POST['uname'];
    $uemail = $_POST['uemail'];
    $uphone = $_POST['uphone'];
    $booking_date = $_POST['booking_date'];
    $payment_method = $_POST['payment_method'];
    $status = 'booked'; // Default status for the booking

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Check if the property is already booked
        $checkStmt = $con->prepare("SELECT * FROM bookings WHERE pid = ? AND status = 'booked'");
        $checkStmt->bind_param("i", $pid);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Display message in a styled div
            echo '<div style="display: flex; justify-content: center; align-items: center; height: 100vh; font-size: 24px; text-align: center; background-color: #f8d7da; color: #721c24;"><span style="padding: 20px; border: 2px solid #f5c6cb; border-radius: 8px;">Property Already Booked. 😞</span></div>';
            exit; // Stop further execution
        }

        // Prepare and bind
        $stmt = $con->prepare("INSERT INTO bookings (pid, uid, uname, uemail, uphone, booking_date, payment_method, status) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissssss", $pid, $uid, $uname, $uemail, $uphone, $booking_date, $payment_method, $status);

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Error: " . $stmt->error);
        }

        // Update the status of the property to 'sold'
        $updateStmt = $con->prepare("UPDATE property SET status='sold' WHERE pid=? AND status='available'");
        $updateStmt->bind_param("i", $pid);

        if (!$updateStmt->execute()) {
            throw new Exception("Error: " . $updateStmt->error);
        }

        // Commit the transaction
        mysqli_commit($con);

        // Display success message with green tick image
        echo '<div style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #d4edda; color: #155724; text-align: center; font-size: 24px;">
                <img src="./images/green_tick.png" alt="Green Tick" style="width: 50px; height: 50px; margin-right: 10px;">
                <span>Booking successful.</span>
              </div>';
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        mysqli_rollback($con);
        echo '<div style="text-align: center; color: #721c24; font-size: 18px; padding: 20px;">' . $e->getMessage() . '</div>';
    } finally {
        // Close statements if they are initialized
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($updateStmt)) {
            $updateStmt->close();
        }
        if (isset($checkStmt)) {
            $checkStmt->close();
        }
    }
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($con);
?>

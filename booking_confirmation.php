<?php
// Start session (if not already started)
session_start();

// Include database connection code
include('config.php');

// Check if booking ID is provided via GET
if(isset($_GET['bid'])) {
    $booking_id = $_GET['bid'];

    // Fetch booking details from database
    $query = mysqli_query($con, "SELECT * FROM bookings WHERE id = '$booking_id'");
    $booking = mysqli_fetch_assoc($query);

    if($booking) {
        // Display booking confirmation details
        ?>
        <div class="booking-confirmation">
            <h3>Booking Confirmation</h3>
            <p>Thank you for your booking!</p>
            <p>Booking Reference Number: <?php echo $booking['id']; ?></p>
            <p>Property: <?php echo $booking['pid']; ?></p>
            <p>Contact us for any further assistance.</p>
        </div>
        <?php
    } else {
        echo "Booking not found.";
    }
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($con);
?>

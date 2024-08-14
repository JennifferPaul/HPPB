<?php
// Start session (if not already started)
session_start();

// Include database connection code
include('config.php');

// Check if property ID is provided via GET
if (isset($_GET['property_id'])) {
    $pid = $_GET['property_id'];

    // Fetch property details from database
    $query = mysqli_query($con, "SELECT * FROM property WHERE pid = '$pid'");
    $property = mysqli_fetch_assoc($query);

    // Check if user is logged in
    if (isset($_SESSION['uid'])) {
        // Fetch user details from database
        $uid = $_SESSION['uid'];
        $user_query = mysqli_query($con, "SELECT * FROM user WHERE uid = '$uid'");
        $user = mysqli_fetch_assoc($user_query);

        // Display booking form with pre-filled user details
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Add custom styles here */
        .booking-form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .booking-form h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .booking-form form label {
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;
        }
        .booking-form form input[type="text"],
        .booking-form form input[type="email"],
        .booking-form form input[type="date"],
        .booking-form form select {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .booking-form form button {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        .booking-form form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md py-4">
        <div class="container mx-auto">
            <!-- Header content goes here -->
        </div>
    </header>

    <!-- Main content -->
    <main class="container mx-auto py-8">
        <section class="booking-form">
            <h3>Booking Details</h3>
            <form action="process_booking.php" method="POST">
                <input type="hidden" name="pid" value="<?= $pid ?>">
                <input type="hidden" name="uid" value="<?= $uid ?>">
                
                <label for="uname">Full Name:</label>
                <input type="text" id="uname" name="uname" value="<?= $user['uname'] ?>" required class="border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">

                <label for="uemail">Email:</label>
                <input type="email" id="uemail" name="uemail" value="<?= $user['uemail'] ?>" required class="border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">

                <label for="uphone">Phone Number:</label>
                <input type="text" id="uphone" name="uphone" value="<?= $user['uphone'] ?>" required class="border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">

                <label for="booking_date">Booking Date:</label>
                <input type="date" id="booking_date" name="booking_date" required class="border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">

                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required class="border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="razorpay">Razorpay</option>
                    <!-- Add more options as needed -->
                </select>

                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Book</button>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto">
            <!-- Footer content goes here -->
        </div>
    </footer>

    <!-- Include JavaScript files or scripts if necessary -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    } else {
        // If user is not logged in, redirect to login page
        header('Location: login.php');
        exit();
    }
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($con);
?>

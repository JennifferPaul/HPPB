<?php
// Start session (if not already started)
session_start();

// Include database connection code
include('config.php');
require __DIR__ . '/vendor/autoload.php'; // Include Razorpay SDK autoload

// Check if form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input (example, you should validate and sanitize all input fields)
    $pid = mysqli_real_escape_string($con, $_POST['pid']);
    $uid = mysqli_real_escape_string($con, $_POST['uid']);
    $booking_date = mysqli_real_escape_string($con, $_POST['booking_date']);
    $status = 'pending'; // Default status

    // Fetch user details from database
    $user_query = mysqli_query($con, "SELECT uname, uemail, uphone FROM user WHERE uid = '$uid'");
    $user = mysqli_fetch_assoc($user_query);

    // Check if user details were fetched successfully
    if ($user) {
        $uname = mysqli_real_escape_string($con, $user['uname']);
        $uemail = mysqli_real_escape_string($con, $user['uemail']);
        $uphone = mysqli_real_escape_string($con, $user['uphone']);

        // Handle payment method (Razorpay)
        if (isset($_POST['payment_method']) && $_POST['payment_method'] === "razorpay") {
            // Set up Razorpay
            $keyId = 'YOUR_RAZORPAY_KEY_ID';
            $keySecret = 'YOUR_RAZORPAY_KEY_SECRET';

            // Create an instance of Razorpay\Client
            $api = new Razorpay\Api\Api($keyId, $keySecret);

            // Prepare the order details
            $orderData = [
                'amount' => 50000, // Amount in paise (₹500)
                'currency' => 'INR',
                'receipt' => 'order_rcptid_' . time(),
                'payment_capture' => 1 // Auto capture payment
            ];

            // Create Razorpay order
            try {
                $order = $api->order->create($orderData);
                $orderId = $order['id'];

                // Store essential booking details in session
                $_SESSION['pid'] = $pid;
                $_SESSION['uid'] = $uid;
                $_SESSION['booking_date'] = $booking_date;
                $_SESSION['razorpay_order_id'] = $orderId;

                // Prepare Razorpay payment form and redirect
                $razorpayPaymentUrl = 'https://api.razorpay.com/v1/payment_embed';
                $redirectUrl = 'http://localhost/yourapp/payment_process_razorpay.php';

                echo "<form action='{$razorpayPaymentUrl}' method='POST'>
                          <input type='hidden' name='key_id' value='{$keyId}'>
                          <input type='hidden' name='order_id' value='{$orderId}'>
                          <input type='hidden' name='name' value='{$uname}'>
                          <input type='hidden' name='description' value='Booking Payment'>
                          <input type='hidden' name='prefill[name]' value='{$uname}'>
                          <input type='hidden' name='prefill[email]' value='{$uemail}'>
                          <input type='hidden' name='prefill[contact]' value='{$uphone}'>
                          <input type='hidden' name='amount' value='{$orderData['amount']}'>
                          <input type='hidden' name='currency' value='{$orderData['currency']}'>
                          <input type='hidden' name='callback_url' value='{$redirectUrl}'>
                          <button type='submit'>Proceed to Razorpay</button>
                      </form>";

                // Optionally, you can redirect to Razorpay payment page directly
                // header("Location: {$razorpayPaymentUrl}");
                // exit();
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid payment method selected.";
        }
    } else {
        echo "User details not found.";
    }
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($con);
?>

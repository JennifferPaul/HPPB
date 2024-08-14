<?php
// Initialize database connection
$con = mysqli_connect("localhost", "root", "panda", "sys");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Start the session
session_start();

// Function to verify agent credentials
function verifyAgentCredentials($email, $password, $con) {
    // Escape inputs to prevent SQL injection
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    // Hash the password (if necessary, based on your database schema)
    $password = sha1($password); // Update this according to your actual hashing method

    // Query to fetch user details by email and password
    $query = "SELECT * FROM user WHERE uemail='$email' AND upass='$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Check if the user type is 'agent'
        if ($row['utype'] === 'agent') {
            // Agent found, return true
            return true;
        }
    }
    
    // Agent not found or credentials don't match
    return false;
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (verifyAgentCredentials($email, $password, $con)) {
        // Agent logged in successfully
        $_SESSION['uemail'] = $email; // Store email in session for future use if needed
        header("location: agent_dashboard.php"); // Redirect to agent dashboard
        exit();
    } else {
        $error = "Email or Password does not match or user is not an agent.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4A90E2, #50C878);
        }

        .container {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .error-message {
            color: #ff0000;
            font-weight: bold;
            margin-top: 1rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-container">
            <h1 class="text-2xl font-bold mb-4">Agent Login</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

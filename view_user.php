<?php
// Include config.php from the parent directory
include("./config.php");

// Start the session
session_start();

// Check if userId is set in session
if (!isset($_SESSION['uid'])) {
    // Redirect or handle unauthorized access
    header("Location: login.php"); // Redirect to login page or handle unauthorized access
    exit();
}

// Get the user ID from the query string
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details
    $userQuery = "SELECT * FROM user WHERE uid = '$userId'";
    $userResult = mysqli_query($con, $userQuery);

    // Check if user exists
    if (mysqli_num_rows($userResult) > 0) {
        $userRow = mysqli_fetch_assoc($userResult);
        $userName = $userRow['uname'];
        $userEmail = $userRow['uemail'];
        $userPhone = $userRow['uphone'];

        // Fetch properties posted by this user
        $propertyQuery = "SELECT * FROM property WHERE uid = '$userId'";
        $propertyResult = mysqli_query($con, $propertyQuery);

        // Start HTML content
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Details - <?php echo htmlspecialchars($userName); ?></title>
            <!-- Include CSS stylesheets or link to external stylesheets -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <link rel="stylesheet" href="styles.css">
        </head>
        <body class="bg-gray-100">
            <!-- Header -->
            <header id="header" class="bg-white shadow-md py-4">
                <div class="container mx-auto">
                    <!-- Header content goes here -->
                </div>
            </header>

            <!-- Main content -->
            <main class="container mx-auto py-8">
                <section id="user-details" class="bg-white shadow-md rounded-lg p-6">
                    <div class="container mx-auto">
                        <h2 class="text-2xl font-bold mb-4">User Details - <?php echo htmlspecialchars($userName); ?></h2>
                        <div class="user-info mb-6">
                            <p><strong>User ID:</strong> <?php echo $userId; ?></p>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($userName); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($userEmail); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($userPhone); ?></p>
                        </div>

                        <h3 class="text-xl font-semibold mb-4">Properties Posted by <?php echo htmlspecialchars($userName); ?></h3>
                        <div class="table-responsive">
                            <table class="table-auto min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="px-4 py-2">Property ID</th>
                                        <th class="px-4 py-2">Title</th>
                                        <th class="px-4 py-2">Description</th>
                                        <th class="px-4 py-2">Price</th>
                                        <th class="px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($propertyRow = mysqli_fetch_assoc($propertyResult)) {
                                        echo "<tr class='border-b border-gray-200'>";
                                        echo "<td class='px-4 py-2'>{$propertyRow['pid']}</td>";
                                        echo "<td class='px-4 py-2'>{$propertyRow['title']}</td>";
                                        echo "<td class='px-4 py-2'>{$propertyRow['pcontent']}</td>";
                                        echo "<td class='px-4 py-2'>{$propertyRow['price']}</td>";
                                        echo "<td class='px-4 py-2'>";
                                        echo "<a href='submitpropertyupdate.php?id={$propertyRow['pid']}' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2'>Edit</a>";
                                        echo "<a href='submitpropertydelete.php?id={$propertyRow['pid']}' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Delete</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Add Property Button -->
                        <form action="submitproperty.php" method="POST" class="mt-6">
                        <input type="hidden" name="uid" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add Property for <?php echo htmlspecialchars($userName); ?></button>
                    </form>
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <footer class="bg-gray-800 text-white py-4">
                <div class="container mx-auto">
                    <!-- Footer content goes here -->
                </div>
            </footer>

            <!-- Include JavaScript files or scripts if necessary -->
            <script src="scripts.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}

// Close connection
mysqli_close($con);
?>

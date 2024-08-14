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

// Get the logged-in agent's ID from the session
$loggedInAgentId = $_SESSION['uid'];

// Fetch users managed by this agent
$userQuery = "SELECT * FROM user WHERE agentId = '$loggedInAgentId'";
$userResult = mysqli_query($con, $userQuery);

// Check if query executed successfully
if ($userResult) {
    // Start HTML content
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agent Dashboard - Manage Users</title>
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- Include TailwindCSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="styles.css">
    </head>
    <body class="bg-gray-100">
        <header id="header" class="fixed top-0 left-0 right-0 bg-white shadow-md">
            <!-- Header code remains the same as before -->
        </header>

        <nav class="bg-gray-800 text-white py-4">
            <!-- Navigation bar code remains the same as before -->
        </nav>

        <main class="container mx-auto mt-8">
            <section id="manage-users">
                <div class="container mx-auto">
                    <h2 class="text-2xl font-bold mb-4">Manage Users</h2>
                    <div class="overflow-x-auto">
                        <table class="table-auto min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-2">User ID</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Email</th>
                                    <th class="px-4 py-2">Phone</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($userRow = mysqli_fetch_assoc($userResult)) {
                                    echo "<tr class='border-b border-gray-200'>";
                                    echo "<td class='px-4 py-2'>{$userRow['uid']}</td>";
                                    echo "<td class='px-4 py-2'>{$userRow['uname']}</td>";
                                    echo "<td class='px-4 py-2'>{$userRow['uemail']}</td>";
                                    echo "<td class='px-4 py-2'>{$userRow['uphone']}</td>";
                                    echo "<td class='px-4 py-2'>";
                                    echo "<a href='view_user.php?id={$userRow['uid']}' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>View</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-800 text-white py-4">
            <!-- Footer code remains the same as before -->
        </footer>

        <!-- Include Bootstrap and TailwindCSS JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    // Handle query error
    echo "Error: " . mysqli_error($con);
}

// Close connection
mysqli_close($con);
?>

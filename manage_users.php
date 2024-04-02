<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Database credentials
$host = "localhost";
$db_username = "root";
$db_password = "";
$database = "file_inventory";

// Create a database connection
$conn = new mysqli($host, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Query to fetch user information based on user ID
$user_query = "SELECT username FROM users WHERE user_id = $user_id";
$user_result = $conn->query($user_query);

// Check if user information is fetched successfully
if ($user_result && $user_result->num_rows > 0) {
    // Fetch user data
    $user_data = $user_result->fetch_assoc();
    // Get the username
    $username = $user_data['username'];
} else {
    // Handle error if user data is not found
    $username = "Unknown";
}

// Query to fetch all users
$users_query = "SELECT * FROM users";
$users_result = $conn->query($users_query);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/manage_users.css"> <!-- Include the CSS file -->
</head>
<body>

<div id="background-container"></div>

<div id="topbar">
    <h2>PSA-CAR SOCD LibSys</h2>
    <div class="dropdown">
        <img src="dropdown_icon.png" alt="Dropdown Icon" width="50" height="50">
        <div class="dropdown-content">
            <p>Logged in as: <?php echo $username; ?></p>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<div id="sidebar">
    <div id="sidebar-content">
        <ul style="margin-top: 50px;">
            <li><a href="admin_dashboard.php" class="sidebar-link">Home</a></li>
            <li style="margin-top: 20px;"> <a href="manage_files.php" class="sidebar-link">Manage Files</a></li>
            <li style="margin-top: 20px;"> <a href="manage_users.php" class="sidebar-link">Manage Users</a></li>
            <!-- Add more options here -->
        </ul>
    </div>
</div>

<div id="content-container">
    <h2>Registered Users</h2>
    <div class="user-details">
        <?php
        // Check if users are fetched successfully
        if ($users_result && $users_result->num_rows > 0) {
            // Display the summary details of users
            while ($row = $users_result->fetch_assoc()) {
                echo "<div class='user-details'>";
                echo "<p><strong>Username:</strong> " . $row['username'] . "</p>";
                echo "<p><strong>Password:</strong> " . $row['password'] . "</p>";
                echo "<p><strong>Role:</strong> " . $row['role'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No users found</p>";
        }
        ?>
    </div>
</div>

</body>
</html>

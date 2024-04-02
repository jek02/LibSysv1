<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Check if user is logged in and has admin role, else redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

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

// Query to get the count of files
$file_query = "SELECT COUNT(*) AS file_count FROM Files";
$file_result = $conn->query($file_query);
$file_count = $file_result->fetch_assoc()['file_count'];

// Query to get the count of users
$user_query = "SELECT COUNT(*) AS user_count FROM users";
$user_result = $conn->query($user_query);
$user_count = $user_result->fetch_assoc()['user_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
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
    <p><strong>Dashboard</strong></p>
        <ul style="margin-top: 50px;"> <!-- Adjust the margin-top value as needed -->
            <li><a href="manage_files.php" class="sidebar-link" >Manage Files</a></li>
            <li style="margin-top: 20px;"><a href="manage_users.php" class="sidebar-link" >Manage Users</a></li>
            <!-- Add more options here -->
        </ul>
    </div>
</div>

<div id="content-container">
    <div class="summary-box">
        <h3>
            <img src="files_icon.png" alt="Files Icon">
            Total Files: <?php echo $file_count; ?>
        </h3>
    </div>
    <div class="summary-box">
        <h3>
            <img src="users_icon.png" alt="Users Icon">
            Total Users: <?php echo $user_count; ?>
        </h3>
    </div>
    <!-- Add more summary boxes here -->
</div>

</body>
</html>

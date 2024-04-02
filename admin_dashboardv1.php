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
    <style>
        /* Common styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Desktop styles */
        @media only screen and (min-width: 768px) {
            #sidebar {
                width: 220px;
                position: fixed;
                top: 40px;
                bottom: 0;
            }

            #content-container {
                margin-left: 240px;
                margin-top: 70px;
            }

            .summary-box {
                width: auto;
                margin-right: 20px;
                margin-bottom: 20px;
                float: left;
            }
        }

        /* Mobile styles */
        @media only screen and (max-width: 767px) {
            #sidebar {
                width: 100%;
                position: static;
            }

            #content-container {
                margin-left: 0;
                margin-top: 110px;
            }

            .summary-box {
                width: auto;
                margin-right: 20px;
                margin-bottom: 20px;
                float: none;
            }
        }

        /* Common styles */
        #background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('BgV2.png');
            background-size: cover;
            opacity: 0.5;
            z-index: -1;
        }

        #topbar {
            background-color: #0f5298;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        #topbar .dropdown {
            position: absolute;
            top: 50%;
            left: 90%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        #topbar .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 150px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1000;
            color: #000000;
        }

        #topbar .dropdown:hover .dropdown-content {
            display: block;
        }

        #topbar .dropdown-content a {
            color: black;
            padding: 10px 10px;
            text-decoration: none;
            display: block;
        }

        #topbar .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        #sidebar {
            background-color: #2565AE;
            color: #fff;
            padding: 20px;
            z-index: 999;
        }

        #sidebar h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        #sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #sidebar ul li {
            margin-bottom: 10px;
        }

        #sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 5px 0;
        }

        #sidebar-content {
            margin-top: 50px;
        }

        #content-container {
            margin-top: 90px;
            padding: 20px;
            overflow: hidden; /* Clear floats */
        }

        .summary-box {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 50px;
            margin-top: 20px;
        }

        .summary-box h3 {
            margin-top: 10px;
            display: flex;
            align-items: center;
            margin-left: 10px;
        }

        .summary-box img {
            margin-right: 25px;
            max-height: 65px;
        }
    </style>
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
        <ul>
            <li><a href="manage_files.php">Manage Files</a></li>

            <li><a href="manage_users.php">Manage Users</a></li>
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

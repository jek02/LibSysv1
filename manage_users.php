<?php
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/manage_users.css">
</head>
<body>

<div id="background-container"></div>

    <div id="topbar">
        <h2>PSA-CAR SOCD LibSys</h2>
        <div class="dropdown">
            <img src="ICON-1.png" alt="Dropdown Icon" width="50" height="50">
            <div class="dropdown-content">
                <p>Logged in as: <?php echo $username; ?></p>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <div id="sidebar">
        <div id="sidebar-content">
            <ul>
                <li><a href="admin_dashboard.php" class="sidebar-link" >Home</a></li>
            </ul>
        </div>
    </div>

    <div id="content">
        <h2>List of Users</h2>
        <?php
        if ($users_result && $users_result->num_rows > 0) {
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr style='background-color: white;'>";
            echo "<th>ID</th>";
            echo "<th>Username</th>";
            echo "<th>Password</th>";
            echo "<th>Role</th>";
            echo "</tr>";
            
            while ($row = $users_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No users found.";
        }
        ?>
    </div>
  
</body>
</html>

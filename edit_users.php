<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if user ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: manage_users.php"); // Redirect to manage users page if user ID is not provided
    exit();
}

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

// Get the user ID from the URL parameter
$user_id = $_GET['id'];

// Query to fetch user information based on user ID
$user_query = "SELECT * FROM users WHERE user_id = $user_id";
$user_result = $conn->query($user_query);

// Check if user information is fetched successfully
if ($user_result && $user_result->num_rows > 0) {
    // Fetch user data
    $user_data = $user_result->fetch_assoc();
} else {
    // Redirect to manage users page if user not found
    header("Location: manage_users.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Update user credentials in the database
    $update_query = "UPDATE users SET username='$username', password='$password', role='$role' WHERE user_id=$user_id";

    if ($conn->query($update_query) === TRUE) {
        echo "User credentials updated successfully";
    } else {
        echo "Error updating user credentials: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="edit_users.css">
</head>
<body>

<div id="background-container"></div>

<div id="topbar">
    <h2>PSA-CAR SOCD LibSys</h2>
    <div class="dropdown">
        <img src="ICON-4.png" alt="Dropdown Icon" width="68" height="68">
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
            <li><a href="#" class="sidebar-link" >Add User</a></li>
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
        echo "<th>Action</th>";
        echo "</tr>";
        
        while ($row = $users_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td>" . $row['role'] . "</td>";
            echo "<td><button class='btn btn-primary'>Edit</button> <button class='btn btn-danger'>Delete</button></td>";
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

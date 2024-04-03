<?php
// Start the session
session_start();


// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "file_inventory";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Files</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="manage_files.css">
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
                <li><a href="manage_users.php" class="sidebar-link" >Manage Users</a></li>
            </ul>
        </div>
    </div>

    <div id="content">
        <h2>List of Files</h2>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM `files`");

        echo "<table class='table table-bordered table-hover'>";
        echo "<tr style='background-color: white;'>";
        echo "<th>ID</th>";
        echo "<th>File Name</th>";
        echo "<th>Author</th>";
        echo "<th>Year</th>";
        echo "<th>Type of Publication</th>";
        echo "<th>Action</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>" . $row['bid'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['type_of_publication'] . "</td>";
            echo "<td>";
            echo "<a href='download.php?id=" . $row['bid'] . "' class='btn btn-primary mr-2'>Download</a>";
            echo "<a href='view.php?id=" . $row['bid'] . "' class='btn btn-success'>View</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>
  
</body>
</html>
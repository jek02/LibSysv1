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
        <img src="ICON-4.png" alt="Dropdown Icon" width="68" height="68">
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
            <li> <a href="add_users.php" class="sidebar-link">Add Users</a></li>
            <!-- Add more options here -->
        </ul>
    </div>
</div>

<div id="content">
    <h2>List of Users</h2>

    <div id="search-container" class="mt-4 d-flex justify-content-between align-items-center" style="width: 100%;">
        <select class="form-control mr-2" id="filter-by" style="width: 40%;">
            <option value="catalog">Users Catalog</option>
            <option value="username">Username</option>
            <option value="role">Role</option>
        </select>
        <input type="text" class="form-control mr-2 shadow" id="search-input" placeholder="Search..." style="width: 200%;">
        <button class="btn btn-primary" id="search-button" style="width: 20%;">Search</button>
    </div>

    <?php

    // Pagination variables
    $limit = 20; // Number of users per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1
    $offset = ($page - 1) * $limit; // Offset calculation

    // Query to fetch users with limit and offset
    $query = "SELECT * FROM `users` LIMIT $limit OFFSET $offset";
    $res = mysqli_query($conn, $query);

    echo "<table class='table table-bordered table-hover'>";
    echo "<tr style='background-color: #e9ecef;'>";
    echo "<th>ID</th>";
    echo "<th>Username</th>";
    echo "<th>Password</th>";
    echo "<th>Role</th>";
    echo "<th>Action</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody id='file-table-body'>";

    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr style='background-color: white;'>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['password'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>";
        echo "<a href='edit_users.php?id=" . $row['user_id'] . "' class='btn btn-primary mr-2'>Edit</a>";
        echo "<span class='separator'>&nbsp;&nbsp;</span>";
        echo "<a href='delete_users.php?id=" . $row['user_id'] . "' class='btn btn-success'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Pagination links
    $total_query = "SELECT COUNT(*) as total FROM `users`";
    $total_result = mysqli_query($conn, $total_query);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_pages = ceil($total_row['total'] / $limit);

    echo "<ul class='pagination justify-content-center'>";
    if ($page > 1) {
        echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "'>Previous</a></li>";
    }

    for ($i = 1; $i <= $total_pages; $i++) {
        // Add class 'active' to the current page link
        $active_class = ($i == $page) ? "active" : "";
        echo "<li class='page-item $active_class'><a class='page-link' href='?page=" . $i . "'>" . $i . "</a></li>";
    }

    if ($page < $total_pages) {
        echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>Next</a></li>";
    }
    echo "</ul>";

    ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Attach click event listener to search button
    $("#search-button").click(function() {
        // Retrieve selected filter criteria and search keyword
        var filterBy = $("#filter-by").val();
        var searchInput = $("#search-input").val();
        console.log("clicked")
        // Send AJAX request
        $.ajax({
            url: "admin_user_search.php", // Path to your PHP script handling the search
            method: "POST",
            data: { filterBy: filterBy, searchInput: searchInput },
            success: function(response) {
                // Update table with search results
                $("#file-table-body").html(response);
            }
        });
    });
});
</script>


</body>
</html>

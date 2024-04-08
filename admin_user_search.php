<?php
// Start the session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and has employee role, else redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: logout.php");
    exit();
}

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

// Retrieve filter criteria and search keyword from POST data
$filterBy = $_POST['filterBy'];
$searchInput = $_POST['searchInput'];

// Prepare SQL statement based on filter criteria
$sql = "SELECT * FROM `users`";
if ($filterBy === "catalog") {
    // Search all fields
    $sql .= " WHERE CONCAT(username, role) LIKE '%$searchInput%'";
} elseif ($filterBy === "username") {
    // Filter by File Name
    $sql .= " WHERE username LIKE '%$searchInput%'";
} elseif ($filterBy === "role") {
    // Filter by Author
    $sql .= " WHERE role LIKE '%$searchInput%'";
}
// Execute SQL query
$res = mysqli_query($conn, $sql);

// Pagination
$limit = 20; // Number of files per page
$total_records = mysqli_num_rows($res);
$total_pages = ceil($total_records / $limit); // Calculate total pages

$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page

$start_index = ($page - 1) * $limit; // Ofafset for SQL query
$sql .= " LIMIT $start_index, $limit"; // Modify SQL query with pagination

$res = mysqli_query($conn, $sql);

function highlightKeyword($content, $keyword) {
    return preg_replace("/($keyword)/i", "<span style='background-color: yellow;'>$1</span>", $content);
}

while ($row = mysqli_fetch_assoc($res)) {
    echo "<tr style='background-color: white;'>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . highlightKeyword($row['username'], $searchInput) . "</td>";
        echo "<td>" . $row['password'] . "</td>";
        echo "<td>" . highlightKeyword($row['role'], $searchInput) . "</td>";
        echo "<td>";
        echo "<a href='edit_users.php?id=" . $row['user_id'] . "' class='btn btn-primary mr-2'>Edit</a>";
        echo "<span class='separator'>&nbsp;&nbsp;</span>";
        echo "<a href='delete_users.php?id=" . $row['user_id'] . "' class='btn btn-success'>Delete</a>";
        echo "</td>";
        echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";


// Close database connection
mysqli_close($conn);
?>

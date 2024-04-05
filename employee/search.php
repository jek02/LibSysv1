<?php
// Start the session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and has employee role, else redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'EMPLOYEE') {
    header("Location: ../logout.php");
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
$sql = "SELECT * FROM `Files`";
if ($filterBy === "catalog") {
    // Search all fields
    $sql .= " WHERE CONCAT(name, author, year, type_of_publication) LIKE '%$searchInput%'";
} elseif ($filterBy === "filename") {
    // Filter by File Name
    $sql .= " WHERE name LIKE '%$searchInput%'";
} elseif ($filterBy === "author") {
    // Filter by Author
    $sql .= " WHERE author LIKE '%$searchInput%'";
} elseif ($filterBy === "year") {
    // Filter by Year
    $sql .= " WHERE year LIKE '%$searchInput%'";
} elseif ($filterBy === "typeofpublication") {
    // Filter by Type of Publication
    $sql .= " WHERE type_of_publication LIKE '%$searchInput%'";
}

// Execute SQL query
$res = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($res)) {
    echo "<tr>";
    echo "<td class='text-center'><b class='small'>" . $row['bid'] . "</b></td>";
    echo "<td class='filename'><b>" . $row['name'] . "</b></td>";
    echo "<td class='text-center align-middle'><b>" . $row['author'] . "</b></td>";
    echo "<td class='text-center align-middle'><b>" . $row['year'] . "</b></td>";
    echo "<td class='text-center align-middle'><b>" . $row['type_of_publication'] . "</b></td>";
    echo "<td class='text-center align-middle'>";
    echo "<a href='download.php?id=" . $row['bid'] . "' class='btn btn-primary mr-2'>Download</a>";
    echo "<a href='view.php?id=" . $row['bid'] . "' class='btn btn-success'>View</a>";
    echo "</td>";
    echo "<td class='text-center align-middle'>";
    echo "<a href='#commentModal' class='btn btn-success comment-btn' data-bid='" . $row['bid'] . "'>View</a>";
    echo " <span class='comment-count'>" . getCommentCount($row['bid']) . "</span>";
    echo "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";

function getCommentCount($file_id) {
    // Include your database connection file if needed
    // include 'db_connection.php';

    // Database connection details
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

    // Query to get comment count
    $sql = "SELECT COUNT(*) AS comment_count FROM Comments WHERE file_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Get the comment count
    $comment_count = 0;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $comment_count = $row['comment_count'];
    }

    $stmt->close();
    $conn->close();

    return $comment_count;
}
// Close database connection
mysqli_close($conn);
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

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

// Check if file_id parameter is set in the GET request
if (isset($_GET['file_id'])) {
    $file_id = mysqli_real_escape_string($conn, $_GET['file_id']);

    $sql = "SELECT user, comment, timestamp FROM Comments WHERE file_id = ? ORDER BY timestamp ";

    $stmt = mysqli_prepare($conn, $sql);


    mysqli_stmt_bind_param($stmt, "s", $file_id);

    mysqli_stmt_execute($stmt);


    $result = mysqli_stmt_get_result($stmt);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output comment data
        while ($row = $result->fetch_assoc()) {
            // Output user, timestamp, and comment in the desired format
            echo "<div class='comment-container'>";
            echo "<div class='comment-info'>";
            echo "<p><strong>" . $row['user'] . "</strong> - " . $row['timestamp'] . "</p>";
            echo "</div>";
            echo "<div class='comment-text'>";
            echo "<p>" . $row['comment'] . "</p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "No comments found for this file.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Return error message if file_id parameter is missing
    echo "Error: file_id parameter is missing.";
}

// Close the database connection
mysqli_close($conn);
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comment Viewer</title>
  <style>
    .comment-container {
        background-color: #f7f7f7;
        padding: 10px;
        margin-bottom: 10px;
    }

    .comment-text {
        margin-left: 20px; /* Adjust the indentation as needed */
    }
  </style>
</head>
<body>

<?php
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

// Retrieve file_id value sent via POST
$file_id = $_POST['bid']; // Assuming 'bid' is equivalent to 'file_id'

$sql = "SELECT user, comment, timestamp FROM Comments WHERE file_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $file_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if any comments were found
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

$stmt->close();
$conn->close();
?>

</body>
</html>

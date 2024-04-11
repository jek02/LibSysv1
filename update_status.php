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
$username = $_SESSION['username'];



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = trim($_POST['status']); // Trim whitespace
    $fileId = $_POST['fileId'];

    // Perform database update
    $sql = "UPDATE Files SET status = ? WHERE bid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $fileId); // 'si' indicates string and integer parameters
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Status updated successfully";
    } else {
        echo "Failed to update status";
    }
}
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the file ID and comment from the form
    $file_id = $_GET['file_id']; // Get file ID from the URL query parameter
    $comment = $_POST['comment'];

    // Prepare SQL statement to insert comment into the database
    $sql = "INSERT INTO Comments (file_id, comment) VALUES ('$file_id', '$comment')";

    // Execute SQL statement
    if (mysqli_query($conn, $sql)) {
        // Show success message using JavaScript
        echo "<script>
                if(confirm('Comment added successfully.')) {
                    window.location.href = 'manage_files.php';
                }
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>

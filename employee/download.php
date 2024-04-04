<?php
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "file_inventory";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Fetch file information from database
        $query = "SELECT * FROM `Files` WHERE bid = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $file_path = $row['files'];
        $file_name = basename($file_path);

        // Check if file exists
        if(file_exists($file_path)) {
            // Set headers for file download
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"$file_name\"");
            readfile($file_path);
            exit;
        } else {
            echo "File not found";
        }
    } else {
        echo "Invalid request";
    }
?>

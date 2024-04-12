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
        
        // Fetch file details from database
        $query = "SELECT * FROM `Files` WHERE bid = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        
        // Check if file exists
        if(file_exists($row['files'])) {
            // Get the file extension
            $file_extension = pathinfo($row['files'], PATHINFO_EXTENSION);
            
            // Determine the appropriate content type based on file extension
            switch($file_extension) {
                case 'pdf':
                    $content_type = 'application/pdf';
                    break;
                case 'jpg':
                case 'jpeg':
                    $content_type = 'image/jpeg';
                    break;
                case 'png':
                    $content_type = 'image/png';
                    break;
                case 'doc':
                case 'docx':
                    $content_type = 'application/msword';
                    break;
                case 'xls':
                case 'xlsx':
                    $content_type = 'application/vnd.ms-excel';
                    break;
                default:
                    $content_type = 'application/octet-stream';
                    break;
            }
            
            // Set the content type header
            header("Content-Type: $content_type");
            
            // Output the file content
            readfile($row['files']);
            exit;
        } else {
            echo "File not found";
            exit;
        }
    } else {
        echo "Invalid request";
        exit;
    }
?>

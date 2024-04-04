<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "file_inventory";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        $stmt = mysqli_prepare($conn, "DELETE FROM `Files` WHERE `bid`=?");
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        
        if(mysqli_stmt_affected_rows($stmt) > 0) {
            header("Location: manage_files.php");
            exit(); 
        } else {
            echo "Error: Failed to delete entry.";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>
                if(confirm('Are you sure you want to delete this entry?')) {
                    window.location.href = 'delete_files.php?id=$id&confirm=yes';
                } else {
                    window.location.href = 'manage_files.php';
                }
              </script>";
    }
}

mysqli_close($conn);
?>

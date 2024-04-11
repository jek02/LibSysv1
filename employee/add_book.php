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
// Get the user ID from the session
$user_id = $_SESSION['user_id'];

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
    <title>Add a File</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="add_book.css">
</head>
<body>

<div id="background-container"></div>

    <div id="topbar">
        <h2>LibSys</h2>
        <div class="dropdown">
            <img src="../ICON-4.png" alt="Dropdown Icon" width="68" height="68">
            <div class="dropdown-content">
                <p>Logged in as: <?php echo $username; ?></p>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
    </div>

    <div id="sidebar">
        <div id="sidebar-content">
            <ul>
                <li><a href="employee_dashboard.php" class="sidebar-link" >Profile</a></li>
                <li><a href="book_list.php" class="sidebar-link" >View Files</a></li>
                <!-- Add more sidebar items as needed -->
            </ul>
        </div>
    </div>

    <div id="content">
    <h2>Add a File</h2>
    <form action="" method="post" enctype="multipart/form-data">
        
        <label for="">File Name:</label>
        <input type="text" name="name" required>
        
        <input type="hidden" name="author" value="<?php echo htmlspecialchars($username); ?>">
        
        
        <input type="hidden" name="year">
        
        <label for="">Type of Publication:</label>
        <input type="text" name="type_of_publication" required>

        <label for="bookFile">Upload Book File:</label>
        <input type="file" id="bookFile" name="bookFile" accept=".pdf, .doc, .docx">

        <input type="submit" name="submit" value="Add File">
    </form>
</div>

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

    if(isset($_POST['submit'])) {
        // Prepare the SQL statement with placeholders
        $query = "INSERT INTO Files (name, author, year, type_of_publication, files) VALUES (?, ?, ?, ?, ?)";
    
        // Bind the parameters
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $name, $author, $year, $type_of_publication, $file_destination);
    
        // Escape and retrieve form data
        $name = $_POST['name'];
        $author = $_POST['author'];
        
        // Format the current date as 'YYYY-MM-DD'
        $year = date('Y-m-d');
        
        $type_of_publication = $_POST['type_of_publication'];
        $file_name = $_FILES['bookFile']['name']; // Get the name of the uploaded file
        $file_tmp = $_FILES['bookFile']['tmp_name']; // Get the temporary location of the uploaded file
        $file_destination = "../uploads/" . $file_name; 
    
        // Move uploaded file and execute the prepared statement
        if (move_uploaded_file($file_tmp, $file_destination)) {
            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "<script>alert('File inserted successfully');</script>";
            } else {
                $error_message = "Error: " . $stmt->error;
                echo "<script>alert('$error_message');</script>";
            }
        } else {
            echo "<script>alert('File upload failed');</script>";
        }
    }
    
?>

</body>
</html>
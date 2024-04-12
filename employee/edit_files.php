<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "";
$database = "file_inventory";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

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


// Check if form is submitted for editing
if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $type_of_publication = $_POST['type_of_publication'];

    // Handle file upload if a new file is selected
    if($_FILES['bookFile']['error'] == 0) {
        // Determine the subdirectory based on file type
        $file_extension = strtolower(pathinfo($_FILES['bookFile']['name'], PATHINFO_EXTENSION));
        switch($file_extension) {
            case 'pdf':
                $subdirectory = 'pdfs';
                break;
            case 'doc':
            case 'docx':
                $subdirectory = 'docs';
                break;
            case 'xls':
            case 'xlsx':
                $subdirectory = 'excels';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
                $subdirectory = 'images';
                break;
            default:
                $subdirectory = 'others';
                break;
        }
        
        // Set the upload directory including the subdirectory
        $upload_directory = '../uploads/' . $subdirectory;

        // Check if the directory exists, if not, create it
        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 0777, true);
        }

        // Generate a unique file name
        $new_file_name = uniqid() . '.' . $file_extension;
        $upload_path = $upload_directory . '/' . $new_file_name;

        // Move uploaded file to specified directory
        if(move_uploaded_file($_FILES['bookFile']['tmp_name'], $upload_path)) {
            // Update file details in the database
            $sql = "UPDATE Files SET name=?, author=?, year=?, type_of_publication=?, files=? WHERE bid=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $name, $author, $year, $type_of_publication, $upload_path, $id);
            if($stmt->execute()) {
                // Redirect to a specific page after updating
                header("Location: ../manage_files.php");
                exit();
            } else {
                echo "Error updating file details: " . $stmt->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        // Update file details in the database without changing the file upload
        $sql = "UPDATE Files SET name=?, author=?, year=?, type_of_publication=? WHERE bid=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $author, $year, $type_of_publication, $id);
        if($stmt->execute()) {
            // Redirect to a specific page after updating
            header("Location: ../manage_files.php");
            exit();
        } else {
            echo "Error updating file details: " . $stmt->error;
        }
    }
}


// Fetch file details if ID is provided
$fileDetails = null;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM Files WHERE bid=$id");
    $fileDetails = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit File</title>
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
        <ul style="margin-top: 50px;">
            <li><a href="../admin_dashboard.php" class="sidebar-link">Home</a></li>
            <li style="margin-top: 20px;"> <a href="../manage_files.php" class="sidebar-link">View Files</a></li>
            <li style="margin-top: 20px;"> <a href="add_book_admin.php" class="sidebar-link">Add Files</a></li>

            <!-- Add more options here -->
        </ul>
    </div>
    </div>

    <div id="content">
    <h2>Edit File</h2>
    <form action="" method="post" enctype="multipart/form-data">
        
    <label for="name">File Name:</label>
    <input type="text" name="name" id="name" value="<?php echo isset($fileDetails['name']) ? htmlspecialchars($fileDetails['name']) : ''; ?>" required>
        
    <input type="hidden" name="author" value="<?php echo isset($fileDetails['author']) ? htmlspecialchars($fileDetails['author']) : ''; ?>">
    
    <input type="hidden" name="year" value="<?php echo isset($fileDetails['year']) ? htmlspecialchars($fileDetails['year']) : ''; ?>">
    
    <label for="type_of_publication">Type of Publication:</label>
    <input type="text" name="type_of_publication" id="type_of_publication" value="<?php echo isset($fileDetails['type_of_publication']) ? htmlspecialchars($fileDetails['type_of_publication']) : ''; ?>" required>

    <label for="bookFile">Upload File:</label>
    <input type="file" id="bookFile" name="bookFile" accept=".pdf, .doc, .docx">
    
    <input type="hidden" name="id" value="<?php echo isset($fileDetails['bid']) ? $fileDetails['bid'] : ''; ?>">
    
    <input type="submit" name="submit" value="Update File">
</form>
</div>
</body>
</html>

<?php mysqli_close($conn); ?>

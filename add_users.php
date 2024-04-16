<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Database credentials
$host = "localhost";
$db_username = "root";
$db_password = "";
$database = "file_inventory";

$conn = new mysqli($host, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

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
    <title>Add a user</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/manage_users.css">
</head>
<body>

<div id="background-container"></div>

    <div id="topbar">
        <h2><a href="admin_dashboard.php">LibSys</a></h2>
        <div class="dropdown">
            <img src="ICON-4.png" alt="Dropdown Icon" width="68" height="68">
            <div class="dropdown-content">
                <p>Logged in as: <?php echo $username; ?></p>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <div id="sidebar">
        <div id="sidebar-content">
            <ul>
                <li><a href="admin_dashboard.php" class="sidebar-link" >Home</a></li>
                <li><a href="manage_users.php" class="sidebar-link" >View Users</a></li>
                <!-- Add more sidebar items as needed -->
            </ul>
        </div>
    </div>

    <div id="content">
    <h2>Add a Users</h2>
    <form action="" method="post" enctype="multipart/form-data">
        
        <label for="">Name:</label>
        <input type="text" name="name" required>

        <label for="">Username:</label>
        <input type="text" name="username" required>
        
        <label for="">Password:</label>
        <input type="text" name="password1" required>
        
        <label for="">Confirm Password:</label>
        <input type="text" name="password2" required>
        
        <label for="">Role:&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <select name="role" required>
            <option value="" selected hidden>Select</option>
            <option value="ADMIN" >ADMIN</option>
            <option value="EMPLOYEE" >EMPLOYEE</option>
        </select> 
        
        <input type="submit" name="submit" value="Register">
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $role = $_POST['role'];

    // Check if passwords match
    if ($password1 !== $password2) {
        echo "Passwords do not match.";
    } else {

        // Prepare and execute SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $username, $password1, $role);

        if ($stmt->execute()) {
            header("Location: manage_users.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

?>

</body>
</html>
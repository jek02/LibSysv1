<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Check if form is submitted for editing
if(isset($_POST['submit'])) {

    $id = $_POST['user_id'];
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $role = $_POST['role'];

    if ($password1 !== $password2) {
        echo "Passwords do not match."; 
    } else {
        // Update user details using prepared statement
        $stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=? WHERE user_id=?");
        $stmt->bind_param("sssi", $username, $password1, $role, $id);
        
        if ($stmt->execute()) {
            header("Location: manage_users.php");
            exit();
        } else {
            echo "Error updating user: " . $stmt->error;
        }
    }
}


$userDetails = null;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id=$id");
    $userDetails = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit a User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="add_users.css">
</head>
<body>

<div id="background-container"></div>

<div id="topbar">
    <h2>PSA-CAR SOCD LibSys</h2>
    <div class="dropdown">
        <img src="../ICON-4.png" alt="Dropdown Icon" width="68" height="68">
        <div class="dropdown-content">
            <p>Logged in as: <?php echo $username; ?></p>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<div id="sidebar">
    <div id="sidebar-content">
        <ul>
            <li><a href="#" class="sidebar-link">Profile</a></li>
            <li><a href="book_list.php" class="sidebar-link">View Files</a></li>
            <!-- Add more sidebar items as needed -->
        </ul>
    </div>
</div>

<div id="content">
    <h2>Edit User</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo $userDetails['user_id']; ?>">

        <label for="">Username:</label>
        <input type="text" name="username" required value="<?php echo $userDetails['username']; ?>">

        <label for="">Password:</label>
        <input type="text" name="password1" required value="<?php echo $userDetails['password']; ?>">

        <label for="">Confirm Password:</label>
        <input type="text" name="password2" required value="<?php echo $userDetails['password']; ?>">

        <label for="">Role:&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <select name="role" required>
            <option value="" hidden>Select</option>
            <option value="ADMIN" <?php if ($userDetails['role'] == 'ADMIN') echo 'selected'; ?>>ADMIN</option>
            <option value="EMPLOYEE" <?php if ($userDetails['role'] == 'EMPLOYEE') echo 'selected'; ?>>EMPLOYEE</option>
        </select>

        <input type="submit" name="submit" value="Update">
    </form>
</div>

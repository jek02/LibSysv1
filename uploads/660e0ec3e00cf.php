<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Start the session
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "file_inventory"; // Replace "your_database_name" with the name of your database

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if user is already logged in, redirect to dashboard if true
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: employee/book_list.php");
        exit();
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role'];

    // Query to fetch user from database
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            // User exists, set session variables and redirect to dashboard
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username']; // Add username to session
            $_SESSION['role'] = $row['role'];

            if ($role == 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: employee/book_list.php");
                exit();
            }
        } else {
            // Invalid credentials, show error message
            $error_message = "Invalid username or password.";
        }
    } else {
        // Query error, show error message or log it for debugging
        $error_message = "Database query error: " . mysqli_error($conn);
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <img src="Logo_Login.png" alt="Logo" class="logo"> <!-- Logo -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Login</h2>
            <?php if (isset($error_message)): ?>
                <p><?php echo $error_message; ?></p>
            <?php endif; ?>
            <label for="username"><strong>Username:</strong></label>
            <input type="text" id="username" name="username" required>
            <label for="password"><strong>Password:</strong></label>
            <input type="password" id="password" name="password" required>
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="admin">ADMIN</option>
                <option value="employee">EMPLOYEE</option>
            </select>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>

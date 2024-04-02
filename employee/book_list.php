<?php
// Start the session
session_start();

// Check if user is logged in and has employee role, else redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'EMPLOYEE') {
    header("Location: login.php");
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
    <title>List of Books</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        #topbar {
            background-color: #0f5298; /* Blue color */
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Higher z-index to keep it on top */
        }
        #topbar h2{
            color:#fff;
        }
        #topbar .dropdown {
            position: absolute;
            top: 50%;
            left: 1190px;
            transform: translateY(-50%);
            right: 20px;
            cursor: pointer;
        }
        #topbar .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 150px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1000;
            color:#000000;
        }
        #topbar .dropdown:hover .dropdown-content {
            display: block;
        }
        #topbar .dropdown-content a {
            color: black;
            padding: 10px 10px;
            text-decoration: none;
            display: block;
        }
        #topbar .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        #sidebar {
            position: fixed;
            top: 40px; /* Adjust top position to accommodate top bar */
            left: 0;
            width: 200px;
            height: 100vh;
            background-color: #2565AE; /* Dark blue color */
            color: #fff;
            padding: 20px;
            z-index: 999; /* Lower z-index to send it behind the top bar */
        }
        #sidebar h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        #sidebar p strong {
            color: #fff; /* Set text color to white */
        }
        #sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #sidebar ul li {
            margin-bottom: 10px;
        }
        #sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 5px 0; /* Add padding to the links */
        }
        #sidebar-content {
            margin-top: 50px; /* Adjust top margin to move sidebar content down */
        }

        #content {
        margin-top: 65px; /* Adjusted to accommodate topbar */
        margin-left: 220px; /* Adjusted to accommodate sidebar width */
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        }

        #book-list {
            margin-top: 20px; /* Add some space between topbar and book list */
            width: calc(100% - 220px); /* Adjusted width to fit content next to sidebar */
            overflow-x: auto; /* Enable horizontal scrolling if needed */
        }

        #book-list table {
            width: 100%;
            border-collapse: collapse;
        }

        #book-list th,
        #book-list td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        #book-list th {
            background-color: #f2f2f2;
            color: #333;
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Set form width */
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="topbar">
        <h2>PSA-CAR SOCD LibSys</h2>
        <div class="dropdown">
            <img src="../dropdown_icon.png" alt="Dropdown Icon" width="50" height="50">
            <div class="dropdown-content">
                <p>Logged in as: <?php echo $username; ?></p>
                <a href="../logout.php">Logout</a>
            </div>
        </div>
    </div>

    <div id="sidebar">
        <div id="sidebar-content">
            <p><strong>Dashboard</strong></p>
            <ul>
                <li><a href="#">Profile</a></li>
                <li><a href="add_book.php">Add a Book</a></li>
                <li><a href="book_list.php">View Books</a></li>
                <!-- Add more sidebar items as needed -->
            </ul>
        </div>
    </div>

    <div id="content">
    <h2>List of Books</h2>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM `books`");

        echo "<table class='table table-bordered table-hover'>";
        echo "<tr style='background-color: white;'>";
        echo "<th>ID</th>";
        echo "<th>Book Name</th>";
        echo "<th>Author</th>";
        echo "<th>Year</th>";
        echo "<th>Type of Publication</th>";
        echo "<th>Action</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>" . $row['bid'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['type_of_publication'] . "</td>";
            echo "<td>";
            echo "<a href='download.php?id=" . $row['bid'] . "' class='btn btn-primary mr-2'>Download</a>";
            echo "<a href='view.php?id=" . $row['bid'] . "' class='btn btn-success'>View</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>
  
</body>
</html>   
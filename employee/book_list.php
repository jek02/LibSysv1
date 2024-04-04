<?php
// Start the session
session_start();

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
    <title>List of Files</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="book_list.css">
</head>
<body>

<div id="background-container"></div>

    <div id="topbar">
        <h2>PSA-CAR SOCD LibSys</h2>
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
                <li><a href="#" class="sidebar-link">Profile</a></li>
                <li><a href="add_book.php" class="sidebar-link" >Add a File</a></li>
                <li><a href="book_list.php" class="sidebar-link" >View Files</a></li>
                <!-- Add more sidebar items as needed -->
            </ul>
        </div>
    </div>

    <div id="content">
    <h2>List of Files</h2>
    <?php
    // Pagination
    $limit = 20; // Number of files per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page
    $offset = ($page - 1) * $limit; // Offset for SQL query

    // Fetch files with pagination
    $sql = "SELECT * FROM `Files` LIMIT $offset, $limit";
    $res = mysqli_query($conn, $sql);

    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-hover'>";
    echo "<thead class='thead-light'>";
    echo "<tr>";
    echo "<th style='width: 5%; font-weight: bold; text-align: center;'>ID</th>";
    echo "<th style='width: 25%; font-weight: bold; text-align: center;'>File Name</th>";
    echo "<th style='width: 20%; font-weight: bold; text-align: center;'>Author</th>";
    echo "<th style='width: 10%; font-weight: bold; text-align: center;'>Year</th>";
    echo "<th style='width: 20%; font-weight: bold; text-align: center;'>Type of Publication</th>";
    echo "<th style='width: 20%; font-weight: bold; text-align: center;'>Action</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td class='text-center'><b class='small'>" . $row['bid'] . "</b></td>";
        echo "<td class='filename'><b>" . $row['name'] . "</b></td>";
        echo "<td class='text-center align-middle'><b>" . $row['author'] . "</b></td>";
        echo "<td class='text-center align-middle'><b>" . $row['year'] . "</b></td>";
        echo "<td class='text-center align-middle'><b>" . $row['type_of_publication'] . "</b></td>";
        echo "<td class='text-center align-middle'>";
        echo "<a href='employee/edit_files.php?id=" . $row['bid'] . "' class='btn btn-primary mr-2'>Edit</a>";
        echo "<a href='delete_files.php?id=" . $row['bid'] . "' class='btn btn-success'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    // Pagination indicators
    echo "<div class='text-center'>";
    $currentPage = $page; // Current page indicator

    // Only display "Previous" button if current page is greater than 1
    if ($currentPage > 1) {
        $prevPage = $page - 1;
        echo "<a href='?page=$prevPage' class='btn btn-secondary mr-2'>Previous</a>";
    }

    // Check if there are more records beyond the current page
    $nextPage = $page + 1;
    $sqlCount = "SELECT COUNT(*) AS total FROM `Files`";
    $resultCount = mysqli_query($conn, $sqlCount);
    $dataCount = mysqli_fetch_assoc($resultCount);
    $totalRows = $dataCount['total'];
    $lastPage = ceil($totalRows / $limit);
    if ($nextPage <= $lastPage) {
        echo "<a href='?page=$currentPage' class='btn btn-secondary mx-2'>$currentPage</a>";
        echo "<a href='?page=$nextPage' class='btn btn-secondary'>Next</a>";
    } else {
        // Disable "Next" button and add spacing
        echo "<a href='?page=$currentPage' class='btn btn-secondary mx-2'>$currentPage</a>";
        echo "<a href='#' class='btn btn-secondary disabled'>Next</a>";
    }
    echo "</div>";
    ?>
</div>



</body>
</html>
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Database credentials
$host = "localhost";
$db_username = "root";
$db_password = "";
$database = "file_inventory";

// Create a database connection
$conn = new mysqli($host, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the session
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
    <title>Manage Files</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/manage_users.css"> 
    <!-- Add your CSS links and other meta tags here -->
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
        <ul style="margin-top: 50px;">
            <li><a href="admin_dashboard.php" class="sidebar-link">Home</a></li>
            <li style="margin-top: 20px;"> <a href="employee/add_book_admin.php" class="sidebar-link">Add Files</a></li>

            <!-- Add more options here -->
        </ul>
    </div>
    </div>

    <div id="content">
    <h2>List of Files</h2>

    <div id="search-container" class="mt-4 d-flex justify-content-between align-items-center" style="width: 100%;">
        <select class="form-control mr-2" id="filter-by" style="width: 40%;">
        <option value="catalog">Library Catalog</option>
            <option value="status">Status</option>
            <option value="filename">File Name</option>
            <option value="author">Uploaded by</option>
            <option value="year">Date Uploaded</option>
            <option value="typeofpublication">Type of Publication</option>
        </select>
        <input type="text" class="form-control mr-2 shadow" id="search-input" placeholder="Search..." style="width: 200%;">
        <button class="btn btn-primary" id="search-button" style="width: 20%;">Search</button>
    </div>

    <?php
    // Pagination
    $limit = 20; // Number of files per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page
    $offset = ($page - 1) * $limit; // Offset for SQL query

    // Fetch files with pagination
    $sql = "SELECT * FROM `Files` ORDER BY `updated_at` DESC LIMIT $offset, $limit";
    $res = mysqli_query($conn, $sql);
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered table-hover'>";
    echo "<thead class='thead-light'>";
    echo "<tr>";
    echo "<th style='width: 25%; font-weight: bold; text-align: center;'class='text-center align-middle'>File Name</th>";
    echo "<th style='width: 15%; font-weight: bold; text-align: center;'class='text-center align-middle'>Uploaded By</th>";
    echo "<th style='width: 10%; font-weight: bold; text-align: center;'class='text-center align-middle'>Date Uploaded</th>";
    echo "<th style='width: 15%; font-weight: bold; text-align: center;'class='text-center align-middle'>Type of Publication</th>";
    echo "<th style='width: 10.5%; font-weight: bold; text-align: center;'class='text-center align-middle'>Status</th>";
    echo "<th style='width: 20%; font-weight: bold; text-align: center;'class='text-center align-middle'>Action</th>";
    echo "<th style='width: 20%; font-weight: bold; text-align: center;'class='text-center align-middle'>Comments</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody id='file-table-body'>";

    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td class='filename'><b>" . $row['name'] . "</b></td>";
        echo "<td class='text-center align-middle'><b>" . $row['author'] . "</b></td>";
        echo "<td class='text-center align-middle'><b>" . $row['year'] . "</b></td>";
        echo "<td class='text-center align-middle'><b>" . $row['type_of_publication'] . "</b></td>";
        
        echo "<td class='text-center align-middle'>";
        echo "<select class='form-control status-dropdown' data-file-id='" . $row['bid'] . "'>";
        echo "<option value='For review'" . ($row['status'] === 'For review' ? ' selected' : '') . ">For review</option>";
        echo "<option value='For revise'" . ($row['status'] === 'For revise' ? ' selected' : '') . ">For revise</option>";
        echo "<option value='Published'" . ($row['status'] === 'Published' ? ' selected' : '') . ">Published</option>";
        echo "</select>";
        echo "</td>";

        echo "<td class='text-center align-middle'>";
        echo "<div class='dropdown'>";
        echo "<button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Actions</button>";
        echo "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
        echo "<a class='dropdown-item' href='employee/edit_files.php?id=" . $row['bid'] . "'>Rename</a>";
        echo "<a class='dropdown-item' href='delete_files.php?id=" . $row['bid'] . "'>Delete</a>";
        echo "<div class='dropdown-divider'></div>";
        echo "<a class='dropdown-item' href='employee/view.php?id=" . $row['bid'] . "'>View</a>";
        echo "<a class='dropdown-item' href='employee/download.php?id=" . $row['bid'] . "'>Download</a>";
        echo "</div>";
        echo "</div>";
        echo "</td>";
        echo "<td class='text-center align-middle'>";
        echo "<button type='button' class='btn btn-success open-modal' data-file-id='" . $row['bid'] . "' data-toggle='modal' data-target='#addCommentModal'>Add</button>";
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

    // Calculate total number of pages
    $sqlCount = "SELECT COUNT(*) AS total FROM `Files`";
    $resultCount = mysqli_query($conn, $sqlCount);
    $dataCount = mysqli_fetch_assoc($resultCount);
    $totalRows = $dataCount['total'];
    $totalPages = ceil($totalRows / $limit);

    // Display page numbers with navigation
    $startPage = max(1, $currentPage - 1);
    $endPage = min($totalPages, $startPage + 2);

    // Display page numbers with "Previous" button
    for ($i = $startPage; $i <= $endPage; $i++) {
        if ($i == $currentPage) {
            echo "<a href='?page=$i' class='btn btn-secondary mx-2 active'>$i</a>";
        } else {
            echo "<a href='?page=$i' class='btn btn-secondary mx-2'>$i</a>";
        }
    }

    // Display ellipsis if there are more pages before the last page
    if ($endPage < $totalPages - 1) {
        echo "<span class='btn btn-secondary mx-2 disabled'>...</span>";
    }

    // Display last page number if not already displayed
    if ($endPage != $totalPages) {
        echo "<a href='?page=$totalPages' class='btn btn-secondary mx-2'>$totalPages</a>";
    }

    // Display "Next" button
    if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        echo "<a href='?page=$nextPage' class='btn btn-secondary'>Next</a>";
    } else {
        echo "<a href='#' class='btn btn-secondary disabled'>Next</a>";
    }

    echo "</div>";
    ?>
</div>

<div class="modal fade" id="addCommentModal" tabindex="-1" role="dialog" aria-labelledby="addCommentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCommentModalLabel">Add Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form id="commentForm" action="" method="post">
        <div class="modal-body w-100" style="max-height:250px; overflow: auto;">
          <label for="comment">Previous Comment:</label>
          <div id="commentBody">
            <!-- Comment content will be loaded here -->
          </div>
        </div>
        <div class="form-group">
          <label for="newComment">Add Comment:</label>
          <textarea class="form-control" id="newComment" name="comment" rows="3" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
    // Use event delegation to handle click events for dynamically added elements
    $('#content').on('click', '.open-modal', function() {
        // Get the value of data-file-id attribute from the clicked button
        var fileId = $(this).data('file-id');
        // Update the action attribute of the form to include the file ID
        $('#commentForm').attr('action', 'add_comment.php?file_id=' + fileId);
    });

    // Attach click event listener to search button
    $("#search-button").click(function() {
        // Retrieve selected filter criteria and search keyword
        var filterBy = $("#filter-by").val();
        var searchInput = $("#search-input").val();

        // Send AJAX request
        $.ajax({
            url: "admin_search.php", // Path to your PHP script handling the search
            method: "POST",
            data: { filterBy: filterBy, searchInput: searchInput },
            success: function(response) {
                // Update table with search results
                $("#file-table-body").html(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    });

    $('.status-dropdown').change(function() {
        var status = $(this).val();
        var fileId = $(this).data('file-id');

        $.ajax({
            url: 'update_status.php',
            method: 'POST',
            data: { status: status, fileId: fileId },
        });
    }); 

    // Function to fetch the most recent comment
    function fetchRecentComment(fileId) {
        $.ajax({
            url: 'prev_comments.php', // Replace with your PHP script to fetch the comment
            type: 'GET',
            data: {
                'file_id': fileId // Send the file-id as part of the request
            },
            success: function(response) {
                // Update the modal body with the fetched comment data
                $('#commentBody').html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Event listener to trigger fetching the recent comment when the modal is shown
    $('#content').on('click', '.open-modal', function() {
        var fileId = $(this).data('file-id');
        fetchRecentComment(fileId);
    });
});
</script>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Function to export assets to CSV
function exportToCSV($filename, $data) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('Name', 'Description', 'Owner'));

    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
}

// Export assets to CSV if requested
if (isset($_GET['export'])) {
    require_once 'config.php';

    $query = "SELECT name, description, owner FROM assets";
    $result = mysqli_query($conn, $query);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);

    exportToCSV('assets.csv', $data);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IT Asset Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        /* Add custom styles here */
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 bg-dark text-white">
            <img src="shape.ico" style="object-fit:scale-down; width:200px; height:300px; border: none 0px #CCC"/>
                <h2>Admin Panel</h2>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_asset.php">Add Asset</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">Search Assets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <!-- Add more menu items as needed -->
                </ul>
                
                <!-- Import CSV Button -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">Import from CSV</button>
                
                <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import from CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Import CSV Form -->
                    <form method="POST" action="import_csv.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="csvFile">CSV File:</label>
                            <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
                        </div>
                        <input type="submit" value="Import" class="btn btn-primary">
                    </form>
                </div>
            </div>
            </div>
            </div>
               
                <a class="nav-link text-white" href="index.php?export=true">Export to CSV</a>
            </div>
            <div class="col-lg-10">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Assets</h2>
    
    <!-- Change View Button -->
    <button type="button" class="btn btn-primary" id="changeViewBtn">Change View</button>

    <!-- Card View -->
    <div id="cardView">
        <?php
        // Display assets as cards
        require_once 'config.php';

        $query = "SELECT * FROM assets";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="row">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-lg-4">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                echo '<p class="card-text">' . $row['description'] . '</p>';
                echo '<a href="view_asset.php?id=' . $row['id'] . '" class="btn btn-primary">View Asset</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "No assets found.";
        }

        mysqli_close($conn);
        ?>
    </div>

    <!-- Table View -->
    <div id="tableView" style="display: none;">
        <?php
        // Display assets in a table with pagination
        require_once 'config.php';

        // Set the number of assets per page
        $assetsPerPage = 10;

        // Get the total number of assets
        $totalAssetsQuery = "SELECT COUNT(*) AS total FROM assets";
        $totalAssetsResult = mysqli_query($conn, $totalAssetsQuery);
        $totalAssets = mysqli_fetch_assoc($totalAssetsResult)['total'];

        // Calculate the total number of pages
        $totalPages = ceil($totalAssets / $assetsPerPage);

        // Get the current page from the query string
        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $currentPage = max(1, min($currentPage, $totalPages));

        // Calculate the offset
        $offset = ($currentPage - 1) * $assetsPerPage;

        // Retrieve the assets for the current page
        $query = "SELECT * FROM assets LIMIT $offset, $assetsPerPage";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table table-striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '<th>Description</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['description'] . '</td>';
                echo '<td><a href="view_asset.php?id=' . $row['id'] . '" class="btn btn-primary">View Asset</a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';

            // Pagination
            echo '<ul class="pagination">';
            for ($page = 1; $page <= $totalPages; $page++) {
                $activeClass = ($page == $currentPage) ? 'active' : '';
                echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $page . '">' . $page . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo "No assets found.";
        }

        mysqli_close($conn);
        ?>
    </div>
</div>
    </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <span>&copy; 2023 Your Company. All rights reserved.</span>
        </div>
    </footer>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

    <script>
        // Change View Button Click Event
        document.getElementById('changeViewBtn').addEventListener('click', function() {
            var cardView = document.getElementById('cardView');
            var tableView = document.getElementById('tableView');

            if (!cardView.style.display || cardView.style.display === 'none') {
                cardView.style.display = 'block';
                tableView.style.display = 'none';
            } else {
                cardView.style.display = 'none';
                tableView.style.display = 'block';
            }
        });
    </script>
</body>
</html>

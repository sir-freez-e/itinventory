<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    $keyword = $_GET['q'];

  
    $query = "SELECT * FROM assets WHERE
          name LIKE '%$keyword%' OR
          description LIKE '%$keyword%' OR
          ci LIKE '%$keyword%' OR
          asset_tag LIKE '%$keyword%'";
// Add more fields to the query

    
    $result = mysqli_query($conn, $query);

    $assets = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $assets[] = $row;
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <style>
        /* Add custom styles here */
   
        .search-results {
            flex: 1;
            margin-right: 20px;
        }

        .assets-container {
            flex: 2;
        }
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
               
            </div>
            </div>
        </div>

    
    <div class="container-fluid">
    
    <div class="jumbotron">
    
    <h1>Search</h1>
    
    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="q" placeholder="Search keywords..." required>
        <div class="form-group">
        <label for="ci">CI:</label>
        <input type="text" name="ci" id="ci" class="form-control">
    </div>
    <div class="form-group">
        <label for="asset_tag">Asset Tag:</label>
        <input type="text" name="asset_tag" id="asset_tag" class="form-control">
    </div>
        <input type="submit" value="Search">
    </form>
    </div>
 
        <div class="search-results">
    <div class="assets-container"> 
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])): ?>
        <?php if (count($assets) > 0): ?>
            <h2>Search Results for "<?php echo $_GET['q']; ?>"</h2>
            <?php foreach ($assets as $asset): ?>
                <div class="row">
                    <div class="col-lg-2">
                        <!-- Left-hand side buttons -->
                        <button class="btn btn-primary">Button 1</button>
                        <a href="update_asset.php?id=<?php echo $asset['id']; ?>" class="btn btn-primary">Update Asset</a>
                    </div>
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $asset['name']; ?></h5>
                                <p class="card-text"><?php echo $asset['description']; ?></p>
                                <a href="view_asset.php?id=<?php echo $asset['id']; ?>" class="btn btn-primary">View Asset</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No results found for "<?php echo $_GET['q']; ?>"</p>
        <?php endif; ?>
    <?php endif; ?>
    </div>
    </div>
    </div>
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <span>&copy; 2023 Your Company. All rights reserved.</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>

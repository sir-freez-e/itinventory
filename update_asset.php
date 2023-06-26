<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $assetId = $_GET['id'];

    // Retrieve the asset details
    $query = "SELECT * FROM assets WHERE id = '$assetId'";
    $result = mysqli_query($conn, $query);
    $asset = mysqli_fetch_assoc($result);

    mysqli_close($conn);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $assetId = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Update the asset details
    $updateQuery = "UPDATE assets SET name = '$name', description = '$description' WHERE id = '$assetId'";
    mysqli_query($conn, $updateQuery);

    mysqli_close($conn);

    // Redirect to the view_asset page after update
    header("Location: view_asset.php?id=$assetId");
    exit();
} else {
    // Invalid request
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Asset</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

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
    <h1>Update Asset</h1>
    <a href="logout.php">Logout</a>

    <form method="POST" action="update_asset.php">
        <input type="hidden" name="id" value="<?php echo $asset['id']; ?>">
        <label for="name">Asset Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $asset['name']; ?>" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo $asset['description']; ?></textarea><br>

        <input type="submit" name="update" value="Update Asset" class="btn btn-primary">
    </form>
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

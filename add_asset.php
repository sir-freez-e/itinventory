<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $owner = $_SESSION['username'];

    $query = "INSERT INTO assets (name, description, owner) VALUES ('$name', '$description', '$owner')";
    mysqli_query($conn, $query);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Asset</title>
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
   
    <div class="col-lg-10">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Description" required></textarea>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="owner">Owner</label>
            <input type="text" name="owner" id="owner" class="form-control" placeholder="Owner" required>
        </div>
        <div class="form-group">
    <label for="ci">CI:</label>
    <input type="text" name="ci" id="ci" class="form-control">
</div>
<div class="form-group">
    <label for="asset_tag">Asset Tag:</label>
    <input type="text" name="asset_tag" id="asset_tag" class="form-control">
</div>
<div class="form-group">
    <label for="warranty_date">Warranty Date:</label>
    <input type="date" name="warranty_date" id="warranty_date" class="form-control">
</div>
<div class="form-group">
    <label for="serial_no">Serial No:</label>
    <input type="text" name="serial_no" id="serial_no" class="form-control">
</div>
<div class="form-group">
    <label for="model_number">Model No:</label>
    <input type="text" name="model_number" id="model_number" class="form-control">
</div>
<div class="form-group">
    <label for="ip_address">IP Address:</label>
    <input type="text" name="ip_address" id="ip_address" class="form-control">
</div>
<div class="form-group">
    <label for="location">Location:</label>
    <input type="text" name="location" id="location" class="form-control">
</div>
<div class="form-group">
    <label for="status">Status:</label>
    <input type="text" name="status" id="status" class="form-control">
</div>
<!-- Add more fields following the same pattern -->

        <input type="submit" value="Add Asset" class="btn btn-primary">
    </form>
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

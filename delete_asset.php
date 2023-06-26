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

    // Delete the asset
    $deleteQuery = "DELETE FROM assets WHERE id = '$assetId'";
    mysqli_query($conn, $deleteQuery);

    mysqli_close($conn);

    // Redirect to the index page after deletion
    header('Location: index.php');
    exit();
} else {
    // Invalid request
    header('Location: index.php');
    exit();
}
?>

<?php
// import_csv.php

// Check if a file was uploaded
if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
    // File details
    $file = $_FILES['csvFile']['tmp_name'];
    $fileName = $_FILES['csvFile']['name'];

    // Validate file extension
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if ($fileExtension !== 'csv') {
        die("Invalid file format. Only CSV files are allowed.");
    }

    // Process the CSV file
    $data = array_map('str_getcsv', file($file));

    // Connect to the database (assuming you have the config.php file included)

    // Perform database operations with the imported data
    foreach ($data as $row) {
        $name = $row[0];
        $description = $row[1];
        $date = $row[2];
        $owner = $row[3];

        // Perform the necessary database insert/update operations here
        // Example:
        // $query = "INSERT INTO assets (name, description, date, owner) VALUES ('$name', '$description', '$date', '$owner')";
        // mysqli_query($conn, $query);
    }

    // Close the database connection
    mysqli_close($conn);

    // Redirect back to the index.php page or show a success message
    header("Location: index.php");
    exit();
} else {
    die("No file uploaded or an error occurred during upload.");
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['asset'])) {
    $assetName = $_POST['asset'];
    
    // Execute ping command and capture the output
    exec("ping -c 1 $assetName", $output, $result);

    // Check the result of the ping command
    if ($result === 0) {
        // Ping was successful
        echo 'Ping successful';
    } else {
        // Ping failed
        echo 'Ping failed';
    }
} else {
    // Invalid request
    echo 'Invalid request';
}

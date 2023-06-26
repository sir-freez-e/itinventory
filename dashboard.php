<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';

$query = "SELECT owner, COUNT(*) as count FROM assets GROUP BY owner";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['owner']] = $row['count'];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                <h1>Dashboard</h1>

              <!-- Live Ping Monitoring Box -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Live Ping Monitoring</h5>
        <p class="card-text" id="pingResult">Performing ping...</p>
    </div>
</div>
<script>
    // Function to perform ping and update card content
    function performPing(assetName) {
        // Perform asynchronous ping request
        $.ajax({
            url: 'ping.php', // Replace 'ping.php' with the actual PHP script for performing the ping
            type: 'POST',
            data: { asset: assetName },
            success: function(response) {
                // Update card content with ping result
                $('#pingResult').text(response);
            },
            error: function() {
                // Handle error
                $('#pingResult').text('Error occurred while pinging the asset.');
            }
        });
    }

    // Perform initial ping on page load
    performPing('<?php echo $asset['name']; ?>');

    // Perform ping every 30 seconds
    setInterval(function() {
        performPing('<?php echo $asset['name']; ?>');
    }, 30000);
</script>

                <!-- Chart Section -->
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="col-lg-6">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <script>
                    var data = <?php echo json_encode($data); ?>;

                    var labels = [];
                    var counts = [];

                    for (var owner in data) {
                        labels.push(owner);
                        counts.push(data[owner]);
                    }

                    var pieCtx = document.getElementById('pieChart').getContext('2d');
                    var pieChart = new Chart(pieCtx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Asset Count',
                                data: counts,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.5)',
                                    'rgba(54, 162, 235, 0.5)',
                                    'rgba(255, 206, 86, 0.5)',
                                    'rgba(75, 192, 192, 0.5)',
                                    'rgba(153, 102, 255, 0.5)',
                                    'rgba(255, 159, 64, 0.5)',
                                    'rgba(255, 99, 132, 0.5)',
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(255, 99, 132, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Asset Count by Owner (Pie Chart)'
                                }
                            }
                        }
                    });

                    var barCtx = document.getElementById('barChart').getContext('2d');
                    var barChart = new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Asset Count',
                                data: counts,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Asset Count by Owner (Bar Chart)'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0
                                }
                            }
                        }
                    });
                </script>

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

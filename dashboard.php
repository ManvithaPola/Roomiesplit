<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    echo "User not found!";
    exit();
}

$group_id = $user['group_id'];

// Fetch all users in the same group
$group_members_result = mysqli_query($conn, "SELECT * FROM users WHERE group_id = '$group_id'");

// Fetch contributions per member
$contributions = [];
$expenses_result = mysqli_query($conn, "SELECT u.name, SUM(e.amount) as total FROM expenses e JOIN users u ON e.paid_by = u.id WHERE u.group_id = '$group_id' GROUP BY e.paid_by");

while ($row = mysqli_fetch_assoc($expenses_result)) {
    $contributions[$row['name']] = $row['total'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - RoomieSplit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include jsPDF from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            background-color: #fdfaf6;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar 
        {
            background-color: #99BC85;
            color: #fff;
            padding: 5px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar h1 
        {
            font-size: 23px;
            font-weight: 500;
        }
        .navbar ul 
        {
            list-style: none;
            display: flex;
        }
        .navbar ul li 
        {
            margin-left: 20px;
        }
        .navbar ul li a 
        {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: 0.3s ease;
        }
        /* .navbar ul li a:hover 
        {
            color: #ff5722;
        } */
        .container {
            margin-top:25px;
        }
        .card {
            border: none;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .btn-custom {
            background-color: #99BC85;
            color: white;
        }
        .chart-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
        }
        .btn-custom {
        background-color: #99BC85;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
    .btn-custom:hover {
        background-color: #7e9c6d;
    }
    </style>
</head>
<body>

<div class="navbar">
            <h1>
                <img src="logo.png" alt="Icon" style="height: 50px; margin-right: 10px; vertical-align: middle;">
                RoomieSplit
            </h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="add_expense.php">Add Expenses</a></li>
                    <li><a href="expenses.php">View Expenses</a></li>
                    <li><a href="room_expenses.php">Room Expenses</a></li>
                    <li><a href="balances.php">Balances</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
</div>
<div class="container">
    <div class="card">
        <h3 class="mb-4">Welcome, <?= htmlspecialchars($user['name']) ?>!</h3>
        <p class="mb-4">Here’s a summary of expenses and contributions for your group:</p>

        <!-- Bar Chart for Member Contributions -->
        <div class="chart-container">
            <canvas id="contributionBarChart"></canvas>
        </div>

        <!-- Pie Chart for Share of Contributions -->
        <div class="chart-container">
            <canvas id="contributionPieChart"></canvas>
        </div>

        <!-- Group members and contributions -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Member Name</th>
                    <th>Total Contribution (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contributions as $name => $total): ?>
                    <tr>
                        <td><?= htmlspecialchars($name) ?></td>
                        <td><?= number_format($total, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>


    </div>
</div>

<script>
    // Bar Chart for contributions
    const barChartCtx = document.getElementById('contributionBarChart').getContext('2d');
    const barChart = new Chart(barChartCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($contributions)) ?>, // Contributor names as X-axis labels
            datasets: [{
                label: 'Total Contributions (₹)',
                data: <?= json_encode(array_values($contributions)) ?>, // Total contribution amounts
                backgroundColor: '#99BC85',
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (₹)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Pie Chart for share of contributions
    const pieChartCtx = document.getElementById('contributionPieChart').getContext('2d');
    const pieChart = new Chart(pieChartCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_keys($contributions)) ?>, // Contributor names as labels
            datasets: [{
                data: <?= json_encode(array_values($contributions)) ?>, // Total contribution amounts
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33B5', '#F2FF33', '#FF5733'],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ₹' + tooltipItem.raw.toFixed(2);
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>

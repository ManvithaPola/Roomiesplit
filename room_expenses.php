<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");
// Check if the session variables are set
if (!isset($_SESSION['user_id']) || !isset($_SESSION['group_id'])) {
    // Handle the case where session variables are not set
    die("User or Group ID not found. Please log in.");
}

$user_id = $_SESSION['user_id'];
$group_id = $_SESSION['group_id'];

$month_filter = isset($_GET['month']) && $_GET['month'] !== '' ? $_GET['month'] : '';
$category_filter = isset($_GET['category']) && $_GET['category'] !== '' ? $_GET['category'] : '';

$conditions = [];
if ($month_filter) {
    $conditions[] = "MONTH(created_at) = '$month_filter' AND YEAR(created_at) = YEAR(CURDATE())";
}
if ($category_filter) {
    $conditions[] = "category = '$category_filter'";
}

$where_sql = '';
if (!empty($conditions)) {
    $where_sql = 'AND ' . implode(' AND ', $conditions);
}

$sql = "SELECT * FROM expenses WHERE group_id = '$group_id' $where_sql ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// Total room expenses
$total_query = "SELECT SUM(amount) as total FROM expenses WHERE group_id = '$group_id' $where_sql";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_expenses = $total_row['total'] ?? 0;

// For bar chart
$chart_query = "SELECT category, SUM(amount) as total FROM expenses WHERE group_id = '$group_id' $where_sql GROUP BY category";
$chart_result = mysqli_query($conn, $chart_query);
$chart_data = [];
while ($row = mysqli_fetch_assoc($chart_result)) {
    $chart_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Room Expenses</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .card {
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 12px;
            margin-bottom:20px;
        }
        .btn-custom {
            background-color: #99BC85;
            color: white;
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
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="expenses.php">View Expenses</a></li>
                    <li><a href="balances.php">Balances</a></li>
                </ul>
            </nav>
</div>

<div class="container mt-5">
    <div class="card p-4">
        <h3>Room Expenses</h3>

        <form method="GET" class="row g-3 mt-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Filter by Month:</label>
                <select name="month" class="form-select">
                    <option value="">All</option>
                    <?php
                    for ($m = 1; $m <= 12; $m++) {
                        $month_name = date("F", mktime(0, 0, 0, $m, 1));
                        $selected = ($month_filter == $m) ? 'selected' : '';
                        echo "<option value='$m' $selected>$month_name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Filter by Category:</label>
                <select name="category" class="form-select">
                    <option value="">All</option>
                    <option value="Groceries" <?= $category_filter == 'Groceries' ? 'selected' : '' ?>>Groceries</option>
                    <option value="Utilities" <?= $category_filter == 'Utilities' ? 'selected' : '' ?>>Utilities</option>
                    <option value="Rent" <?= $category_filter == 'Rent' ? 'selected' : '' ?>>Rent</option>
                    <option value="Entertainment" <?= $category_filter == 'Entertainment' ? 'selected' : '' ?>>Entertainment</option>
                    <option value="Other" <?= $category_filter == 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-custom">Apply</button>
            </div>
        </form>

        <h5>Total Room Expenses: ₹<?= $total_expenses ? number_format($total_expenses, 2) : '0.00' ?></h5>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Paid By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td>₹<?= number_format($row['amount'], 2) ?></td>
                                <td><?= $row['category'] ?></td>
                                <td><?= $row['paid_by'] ?></td>
                                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">No expenses found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            <h5>Expense Distribution by Category</h5>
            <canvas id="barChart" height="100"></canvas>
        </div>

        <div class="mt-4">
            <!-- <button class="btn btn-success me-2" onclick="exportTableToCSV()">Export CSV</button> -->
            <button class="btn btn-danger" onclick="window.print()">Export PDF</button>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('barChart').getContext('2d');
    const chartData = <?= json_encode($chart_data) ?>;
    const labels = chartData.map(item => item.category);
    const data = chartData.map(item => item.total);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '₹ Spent',
                data: data,
                backgroundColor: '#99BC85'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹' + value;
                        }
                    }
                }
            }
        }
    });

    function exportTableToCSV() {
        let csv = "Title,Amount,Category,Paid By,Date\n";
        document.querySelectorAll("table tbody tr").forEach(row => {
            const cols = row.querySelectorAll("td");
            if (cols.length > 0) {
                csv += Array.from(cols).map(col => col.innerText).join(",") + "\n";
            }
        });
        const blob = new Blob([csv], { type: "text/csv" });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "room_expenses.csv";
        link.click();
    }
</script>

</body>
</html>

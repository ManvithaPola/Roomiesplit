<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Clear notifications if requested
if (isset($_POST['clear'])) {
    mysqli_query($conn, "DELETE FROM notifications WHERE user_id = '$user_id'");
    header("Location: notifications.php");
    exit();
}

// Fetch notifications
$result = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id = '$user_id' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Notifications - RoomieSplit</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .container {
            margin-top: 50px;
            max-width: 800px;
        }
        .card {
            border: none;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .notification {
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .time {
            font-size: 0.9em;
            color: gray;
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
                    <li><a href="add_expense.php">Add Expenses</a></li>
                    <li><a href="expenses.php">View Expenses</a></li>
                    <li><a href="balances.php">Balances</a></li>
                </ul>
            </nav>
</div>

<div class="container">
    <div class="card">
        <h3 class="mb-4">🔔 Your Notifications</h3>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="notification">
                    <?= htmlspecialchars($row['message']) ?>
                    <div class="time"><?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></div>
                </div>
            <?php endwhile; ?>
            <form method="post">
                <button type="submit" name="clear" class="btn btn-danger mt-2">Clear All</button>
            </form>
        <?php else: ?>
            <div class="alert alert-info">No notifications yet.</div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

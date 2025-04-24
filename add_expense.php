<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get current user details
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    echo "User not found!";
    exit();
}

$group_id = $user['group_id'];

// Get all group users for "Paid By" dropdown
$group_users_result = mysqli_query($conn, "SELECT id, name FROM users WHERE group_id = '$group_id'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $paid_by = $_POST['paid_by'];

    if ($title && $amount && $category && $paid_by) {
        $stmt = $conn->prepare("INSERT INTO expenses (title, amount, category, paid_by, group_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sdssi", $title, $amount, $category, $paid_by, $group_id);
        $stmt->execute();
        $stmt->close();

        // ✅ Notification logic: Notify all group users except the one who paid
        $notify_result = mysqli_query($conn, "SELECT id FROM users WHERE group_id = '$group_id' AND id != '$paid_by'");
        while ($notify = mysqli_fetch_assoc($notify_result)) {
            $msg = "$title expense of ₹$amount was added. You owe your share.";
            $notify_user = $notify['id'];
            mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ('$notify_user', '$msg')");
        }

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Expense - RoomieSplit</title>
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
            margin-top: 60px;
            max-width: 700px;
        }
        .card {
            border: none;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #99BC85;
            color: white;
        }
        .form-label {
            font-weight: 500;
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

<div class="container">
    <div class="card">
        <h3 class="mb-4">➕ Add New Expense</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="title" class="form-label">Expense Title</label>
                <input type="text" class="form-control" id="title" name="title" required placeholder="e.g., Groceries, Electricity Bill">
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount (₹)</label>
                <input type="number" class="form-control" id="amount" name="amount" required step="0.01">
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="Groceries">Groceries</option>
                    <option value="Utilities">Utilities</option>
                    <option value="Rent">Rent</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Subscriptions">Subscriptions</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="paid_by" class="form-label">Paid By</label>
                <select class="form-select" id="paid_by" name="paid_by" required>
                    <option value="">-- Select Member --</option>
                    <?php while ($member = mysqli_fetch_assoc($group_users_result)): ?>
                        <option value="<?= $member['id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-custom">Add Expense</button>
        </form>
    </div>
</div>

</body>
</html>

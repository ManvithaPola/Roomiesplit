<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to edit your expense.";
    exit();
}

$user_id = $_SESSION['user_id'];  // Get logged-in user's ID

// Get the expense ID to be edited
if (isset($_GET['id'])) {
    $expense_id = $_GET['id'];
    
    // Fetch the expense data from the database
    $query = "SELECT * FROM expenses WHERE id = '$expense_id' AND paid_by = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    // Check if the expense exists
    if (mysqli_num_rows($result) == 0) {
        echo "Expense not found.";
        exit();
    }
    
    $expense = mysqli_fetch_assoc($result);
    
    // Handle form submission for updating expense
    if (isset($_POST['update'])) {
        $title = $_POST['title'];
        $amount = $_POST['amount'];
        $category = $_POST['category'];
        $date = $_POST['date'];

        // Update expense query
        $update_query = "UPDATE expenses SET title = '$title', amount = '$amount', category = '$category', created_at = '$date' WHERE id = '$expense_id' AND paid_by = '$user_id'";
        if (mysqli_query($conn, $update_query)) {
            header("Location: expenses.php"); // Redirect to the expenses page after update
            exit();
        } else {
            echo "Error updating expense.";
        }
    }
} else {
    echo "No expense selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Expense - RoomieSplit</title>
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
      max-width: 900px;
    }

    .card {
      border: none;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .card-title {
      font-size: 24px;
      color: #99BC85;
    }

    .btn-custom {
      background-color: #99BC85;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
    }

    .btn-custom:hover {
      background-color: #3e5b64;
    }

    .form-control, .form-select {
      border-radius: 5px;
      padding: 10px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .table th {
      background-color: #E4EFE7;
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
        <h3 class="card-title mb-4">Edit Expense</h3>

        <form method="POST">
            <div class="form-group">
                <label for="title" class="form-label">Expense Title:</label>
                <input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($expense['title']) ?>" required>
            </div>

            <div class="form-group">
                <label for="amount" class="form-label">Amount (₹):</label>
                <input type="number" step="0.01" class="form-control" name="amount" id="amount" value="<?= $expense['amount'] ?>" required>
            </div>

            <div class="form-group">
                <label for="category" class="form-label">Category:</label>
                <select name="category" class="form-select" required>
                    <option value="Groceries" <?= $expense['category'] == 'Groceries' ? 'selected' : '' ?>>Groceries</option>
                    <option value="Utilities" <?= $expense['category'] == 'Utilities' ? 'selected' : '' ?>>Utilities</option>
                    <option value="Rent" <?= $expense['category'] == 'Rent' ? 'selected' : '' ?>>Rent</option>
                    <option value="Entertainment" <?= $expense['category'] == 'Entertainment' ? 'selected' : '' ?>>Entertainment</option>
                    <option value="Other" <?= $expense['category'] == 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date" class="form-label">Date:</label>
                <input type="date" class="form-control" name="date" id="date" value="<?= date('Y-m-d', strtotime($expense['created_at'])) ?>" required>
            </div>

            <button type="submit" name="update" class="btn-custom mt-4">Update Expense</button>
        </form>
    </div>
</div>

</body>
</html>

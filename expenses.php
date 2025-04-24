<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$filter = isset($_GET['category']) ? $_GET['category'] : '';
$filter_sql = $filter ? "AND category = '$filter'" : "";

$expenses = mysqli_query($conn, "SELECT * FROM expenses WHERE paid_by = '$user_id' $filter_sql ORDER BY created_at DESC");

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM expenses WHERE id = '$delete_id' AND paid_by = '$user_id'");
    header("Location: expenses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Expenses - RoomieSplit</title>
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

    .btn-custom {
      background-color: #99BC85;
      color: white;
    }

    .table th {
      background-color: #E4EFE7;
    }

    .form-control, .form-select {
      border-radius: 5px;
      padding: 10px;
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
                    <li><a href="balances.php">Balances</a></li>
                </ul>
            </nav>
</div>

<div class="container">
  <div class="card">
    <h3 class="mb-4">Your Expenses</h3>

    <form method="GET" class="mb-4">
      <label class="form-label">Filter by Category:</label>
      <select name="category" class="form-select w-50 d-inline-block">
        <option value="">All</option>
        <option value="Groceries" <?= $filter == 'Groceries' ? 'selected' : '' ?>>Groceries</option>
        <option value="Utilities" <?= $filter == 'Utilities' ? 'selected' : '' ?>>Utilities</option>
        <option value="Rent" <?= $filter == 'Rent' ? 'selected' : '' ?>>Rent</option>
        <option value="Entertainment" <?= $filter == 'Entertainment' ? 'selected' : '' ?>>Entertainment</option>
        <option value="Other" <?= $filter == 'Other' ? 'selected' : '' ?>>Other</option>
      </select>
      <button type="submit" class="btn btn-custom ms-2">Apply</button>
    </form>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Amount (₹)</th>
          <th>Category</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($expenses)): ?>
          <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= $row['amount'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
            <td>
              <a href="edit_expense.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>

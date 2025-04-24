<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle payment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_to'], $_POST['amount'])) {
    $pay_to = (int)$_POST['pay_to'];
    $amount = (float)$_POST['amount'];

    // Add a negative expense to the payer
    $stmt1 = $conn->prepare("INSERT INTO expenses (amount, paid_by) VALUES (?, ?)");
    $stmt1->bind_param("di", $amount, $user_id);
    $stmt1->execute();

    // Add a positive expense to the receiver to cancel out what they are owed
    $stmt2 = $conn->prepare("INSERT INTO expenses (amount, paid_by) VALUES (?, ?)");
    $amount = -$amount;
    $stmt2->bind_param("di", $amount, $pay_to);
    $stmt2->execute();
}

// Get all users
$users_result = mysqli_query($conn, "SELECT id, name FROM users");
$users = [];
while ($row = mysqli_fetch_assoc($users_result)) {
    $users[$row['id']] = $row['name'];
}

// Initialize paid amounts
$paid_amounts = array_fill_keys(array_keys($users), 0);

// Get all expenses
$expenses_result = mysqli_query($conn, "SELECT paid_by, amount FROM expenses");
$total_expenses = 0;
while ($expense = mysqli_fetch_assoc($expenses_result)) {
    $total_expenses += $expense['amount'];
    $paid_amounts[$expense['paid_by']] += $expense['amount'];
}

$user_count = count($users);
$equal_share = $user_count > 0 ? $total_expenses / $user_count : 0;

// Calculate balances
$balances = [];
foreach ($paid_amounts as $id => $amount_paid) {
    $balances[$id] = $amount_paid - $equal_share;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Who Owes Whom - RoomieSplit</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fdfaf6;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background-color: #99BC85;
      color: #fff;
      padding: 5px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .navbar h1 {
      font-size: 23px;
      font-weight: 500;
    }
    .navbar ul {
      list-style: none;
      display: flex;
    }
    .navbar ul li {
      margin-left: 20px;
    }
    .navbar ul li a {
      color: #fff;
      text-decoration: none;
      font-size: 16px;
      font-weight: 600;
      transition: 0.3s ease;
    }
    .container {
      margin-top: 50px;
      max-width: 1000px;
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
    .balance-positive {
      color: green;
    }
    .balance-negative {
      color: red;
    }
    form.pay-form {
      display: flex;
      gap: 5px;
      align-items: center;
    }
    input[type="number"] {
      width: 80px;
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
    </ul>
  </nav>
</div>

<div class="container">
  <div class="card">
    <h3 class="mb-4">Who Owes Whom</h3>
    <p>Total Expenses: <strong>₹<?= number_format($total_expenses, 2) ?></strong></p>
    <p>Each Person Should Pay: <strong>₹<?= number_format($equal_share, 2) ?></strong></p>

    <table class="table table-striped mt-4">
      <thead>
        <tr>
          <th>Person</th>
          <th>Paid</th>
          <th>Balance</th>
          <th>Pay</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($balances as $id => $balance): ?>
          <tr>
            <td><?= htmlspecialchars($users[$id]) ?></td>
            <td>₹<?= number_format($paid_amounts[$id], 2) ?></td>
            <td class="<?= $balance >= 0 ? 'balance-positive' : 'balance-negative' ?>">
              <?= $balance >= 0 ? 'Gets ₹' : 'Owes ₹' ?><?= number_format(abs($balance), 2) ?>
            </td>
            <td>
              <?php if ($id != $user_id && $balances[$user_id] < 0 && $balance > 0): ?>
                <form method="post" class="pay-form">
                  <input type="hidden" name="pay_to" value="<?= $id ?>">
                  <input type="number" step="0.01" name="amount" placeholder="₹" max="<?= abs($balances[$user_id]) ?>" min="1" required>
                  <button type="submit" class="btn btn-sm btn-custom">Pay</button>
                </form>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>

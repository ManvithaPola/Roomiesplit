<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

// Check login
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

// Fetch group name
$group_id = $user['group_id'];
$group_result = mysqli_query($conn, "SELECT name FROM groups WHERE id = '$group_id'");
$group = mysqli_fetch_assoc($group_result);
$group_name = $group ? $group['name'] : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile - RoomieSplit</title>
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
            max-width: 1000px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .btn-custom {
            background-color: #99BC85;
            color: white;
        }
        .row-label {
            font-weight: bold;
            color: #444;
        }
        .value-box {
            color: #555;
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
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
</div>

<div class="container">
    <div class="card">
        <h3 class="mb-4">Your Profile</h3>
        <div class="row">
            <div class="col-md-6 mb-3">
                <p class="row-label">Name:</p>
                <p class="value-box"><?= htmlspecialchars($user['name']) ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <p class="row-label">Email:</p>
                <p class="value-box"><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <p class="row-label">Group:</p>
                <p class="value-box"><?= htmlspecialchars($group_name) ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <p class="row-label">Joined On:</p>
                <p class="value-box"><?= date('d M Y', strtotime($user['created_at'])) ?></p>
            </div>
        </div>

        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-custom me-2">Back to Dashboard</a>
            <a href="edit_profile.php" class="btn btn-outline-secondary">Edit Profile</a>
        </div>
    </div>
</div>

</body>
</html>

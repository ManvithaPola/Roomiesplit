<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($user_result);

$success = $error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords match
    if (!empty($new_password)) {
        if ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET name='$name', email='$email', password='$hashed_password' WHERE id='$user_id'";
        }
    } else {
        $update_query = "UPDATE users SET name='$name', email='$email' WHERE id='$user_id'";
    }

    if (empty($error)) {
        if (mysqli_query($conn, $update_query)) {
            $success = "Profile updated successfully!";
            $user_result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
            $user = mysqli_fetch_assoc($user_result); // Refresh user info
        } else {
            $error = "Error updating profile. Try again!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile - RoomieSplit</title>
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
            max-width: 700px;
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
        <h3 class="mb-4">Edit Profile</h3>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <hr>
            <h5 class="mt-3">Change Password (Optional)</h5>
            <div class="mb-3">
                <label class="form-label">New Password:</label>
                <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password">
            </div>
            <button type="submit" class="btn btn-custom">Save Changes</button>
            <a href="profile.php" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>

</body>
</html>

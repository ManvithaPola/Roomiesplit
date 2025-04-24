<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    if ($new_password === $confirm_password) {
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET password = '$new_password_hashed', reset_token = NULL WHERE reset_token = '$token'";
        if (mysqli_query($conn, $update_query)) {
            // Fetch user info to log them in
            $user_query = mysqli_query($conn, "SELECT * FROM users WHERE reset_token IS NULL AND password = '$new_password_hashed' LIMIT 1");
            $user = mysqli_fetch_assoc($user_query);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: dashboard.php");
                exit();
            }
        } else {
            $error = "Something went wrong. Try again.";
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - RoomieSplit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #fdfaf6;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            width: 100%;
            background-color: #99BC85;
            padding: 12px 20px;
            color: white;
            font-weight: bold;
            font-size: 22px;
        }

        .container {
            max-width: 450px;
            margin: 60px auto;
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #99BC85;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #88a876;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: #4CAF50;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }

    </style>
</head>
<body>

<div class="navbar">RoomieSplit</div>

<div class="container">
    <h2>Reset Your Password</h2>
    <?php if (isset($success)): ?>
        <div class="message"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php else: ?>
        <form method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit">Update Password</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>

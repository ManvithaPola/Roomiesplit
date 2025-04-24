<?php
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(32));

    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_user) > 0) {
        mysqli_query($conn, "UPDATE users SET reset_token = '$token' WHERE email = '$email'");
        $reset_link = "http://localhost/roomiesplit/reset_password.php?token=$token";
        $message = "A reset link has been generated: <br><a href='$reset_link' target='_blank'>Click here to reset your password</a>";

    } else {
        $message = "<span style='color:red;'>Email not found!</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | RoomieSplit</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fdfaf6;
        }

        .container {
            max-width: 400px;
            margin: 80px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #99BC85;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #88a977;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #333;
        }

        a {
            color: #4a7c59;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo img {
            height: 50px;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="logo">
            <img src="logo.png" alt="RoomieSplit Logo">
        </div>
        <h2>Forgot Password</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your registered email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <div class="message"><?= $message ?></div>
    </div>

</body>
</html>

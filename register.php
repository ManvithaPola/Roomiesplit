<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $group_id = null;

    // Create new group or join existing
    if (!empty($_POST['new_group'])) {
        $new_group = mysqli_real_escape_string($conn, $_POST['new_group']);
        mysqli_query($conn, "INSERT INTO groups (name) VALUES ('$new_group')");
        $group_id = mysqli_insert_id($conn);
    } elseif (!empty($_POST['group_id'])) {
        $group_id = $_POST['group_id'];
    }

    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_user) > 0) {
        $error = "Email already exists!";
    } else {
        mysqli_query($conn, "INSERT INTO users (name, email, password, group_id) VALUES ('$name', '$email', '$password', '$group_id')");
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - RoomieSplit</title>
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
            margin-top: 80px;
            max-width: 550px;
        }
        .card {
            padding: 35px;
            border-radius: 18px;
            border: none;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #99BC85;
            color: white;
            font-weight: 500;
        }
        .form-label {
            font-weight: 500;
        }
        .form-select, .form-control {
            border-radius: 10px;
        }
        .form-text {
            font-size: 0.9rem;
            color: #666;
        }
        a {
            color: #99BC85;
            text-decoration: none;
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
</div>
<div class="container">
    <div class="card">
        <h3 class="text-center mb-4">Register to RoomieSplit</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required placeholder="">
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Create a secure password">
            </div>

            <div class="mb-3">
                <label class="form-label">Join Existing Group</label>
                <select name="group_id" class="form-select">
                    <option value="">-- Select Group --</option>
                    <?php
                        $groups = mysqli_query($conn, "SELECT * FROM groups");
                        while ($group = mysqli_fetch_assoc($groups)) {
                            echo "<option value='{$group['id']}'>{$group['name']}</option>";
                        }
                    ?>
                </select>
                <div class="form-text">Or create a new group below</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Create New Group</label>
                <input type="text" name="new_group" class="form-control" placeholder="">
            </div>

            <button type="submit" name="register" class="btn btn-custom w-100 mt-3">Register</button>

            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</div>

</body>
</html>

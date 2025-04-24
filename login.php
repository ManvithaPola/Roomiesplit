<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);

  if ($email == "" || $password == "") {
    $error = "Please fill in all fields.";
  } else {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['group_id'] = $user['group_id'];
      header("Location: dashboard.php");
      exit();
    } else {
      $error = "Invalid email or password.";
    }
    mysqli_stmt_close($stmt);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login - RoomieSplit</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #faf1e6;
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
    .login-container {
      max-width: 450px;
      margin: 60px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn-custom {
      background-color: #99bc85;
      color: white;
      font-weight: 500;
    }
    .btn-custom:hover {
      background-color: #7ca96c;
    }
    h2 {
      color: #99bc85;
      font-weight: bold;
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
                    <li><a href="register.php">Register</a></li>
                    <li><a href="forgot_password.php">Forgot Password?</a></li>
                </ul>
            </nav>
</div>
  <div class="container">
    <div class="login-container">
      <h2 class="text-center mb-4">Login to RoomieSplit</h2>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Email address</label>
          <input type="email" class="form-control" name="email" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" required />
        </div>

        <button type="submit" class="btn btn-custom w-100">Login</button>
      </form>

      <p class="mt-3 text-center">
        Don't have an account? <a href="register.php" style="color: #99bc85;">Register here</a>
      </p>
    </div>
  </div>

</body>
</html>

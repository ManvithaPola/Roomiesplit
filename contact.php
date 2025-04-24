<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Contact Us - RoomieSplit</title>
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
      margin: 0;
      padding: 0;
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
      max-width: 700px;
    }
    .card {
      border: none;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      background-color: #ffffff;
    }
    .form-label {
      font-weight: 500;
    }
    .btn-custom {
      background-color: #99BC85;
      color: white;
    }
    footer {
      margin-top: 50px;
      background-color: #E4EFE7;
      text-align: center;
      padding: 20px 10px;
      color: #555;
      font-size: 15px;
      font-weight:500;
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
    </ul>
  </nav>
</div>

<div class="container">
  <div class="card">
    <h3 class="mb-4">Contact Us</h3>
    <p class="mb-4 text-muted">Have a question, suggestion, or just want to say hi? We’d love to hear from you!</p>

    <form method="POST" action="#">
      <div class="mb-3">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Your Email</label>
        <input type="email" class="form-control" id="email" name="email" required placeholder="name@example.com">
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Your Message</label>
        <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Type your message here..."></textarea>
      </div>

      <button type="submit" class="btn btn-custom">Send Message</button>
    </form>
  </div>
</div>

<footer>
  &copy; <?= date("Y") ?> RoomieSplit.  All Rights Reserved. 
</footer>

</body>
</html>

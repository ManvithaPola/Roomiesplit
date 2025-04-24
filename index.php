<?php
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RoomieSplit – Smart Expense Splitter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
  <style>
    :root {
      --primary: #99BC85;
      --primary-dark: #7ca96c;
      --secondary: #E4EFE7;
      --light-bg: #FAF1E6;
      --lightest-bg: #FDF8EE;
      --white: #FFFFFF;
      --text-dark: #333333;
    }
    
    body {
      background-color: var(--light-bg);
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
    }
    
    /* Navbar Styles */
    .navbar {
      background-color: var(--primary);
      padding: 0.7rem 2rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      transition: all 0.3s ease;
    }
    
    .navbar.scrolled {
      padding: 0.5rem 2rem;
      background-color: rgba(153, 188, 133, 0.95);
      backdrop-filter: blur(10px);
    }
    
    .navbar-brand {
      display: flex;
      align-items: center;
      color: var(--white);
      font-weight: 600;
      font-size: 1.5rem;
    }
    
    .navbar-brand img {
      height: 45px;
      margin-right: 10px;
      transition: transform 0.3s ease;
    }
    
    .navbar-brand:hover img {
      transform: rotate(10deg);
    }
    
    .nav-link {
      color: var(--white) !important;
      font-weight: 500;
      margin-left: 10px;
      position: relative;
      padding: 8px 15px !important;
    }
    
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 50%;
      background-color: var(--white);
      transition: all 0.3s ease;
    }
    
    .nav-link:hover::after {
      width: 80%;
      left: 10%;
    }
    
    /* Hero Section */
    .hero-section {
      padding-top: 90px;
      min-height: 100vh;
      background: linear-gradient(135deg, var(--lightest-bg) 0%, var(--light-bg) 100%);
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
    }
    
    .hero-content {
      position: relative;
      z-index: 2;
    }
    
    .hero-title {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      background: linear-gradient(90deg, var(--primary-dark), var(--primary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    
    .hero-subtitle {
      font-size: 1.3rem;
      color: var(--text-dark);
      margin-bottom: 2rem;
    }
    
    .hero-shape {
      position: absolute;
      bottom: -50px;
      right: -50px;
      width: 300px;
      height: 300px;
      background-color: var(--primary);
      opacity: 0.1;
      border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
      z-index: 1;
      animation: morphShape 15s ease-in-out infinite;
    }
    
    @keyframes morphShape {
      0% {
        border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
      }
      50% {
        border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%;
      }
      100% {
        border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
      }
    }
    
    .btn-custom {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 50px;
      transition: all 0.3s ease;
      font-weight: 600;
      box-shadow: 0 4px 15px rgba(153, 188, 133, 0.4);
    }
    
    .btn-custom:hover {
      background-color: var(--primary-dark);
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(153, 188, 133, 0.6);
    }
    
    .btn-outline-custom {
      color: var(--primary);
      border: 2px solid var(--primary);
      background-color: transparent;
      padding: 12px 30px;
      border-radius: 50px;
      transition: all 0.3s ease;
      font-weight: 600;
      margin-left: 15px;
    }
    
    .btn-outline-custom:hover {
      background-color: var(--primary);
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(153, 188, 133, 0.3);
    }
    
    /* Features Section */
    .section-title {
      position: relative;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 3rem;
    }
    
    .section-title::after {
      content: '';
      position: absolute;
      width: 80px;
      height: 4px;
      background-color: var(--primary);
      bottom: -15px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 2px;
    }
    
    .process-card {
      background-color: var(--white);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      transition: all 0.4s ease;
      height: 100%;
      border: none;
    }
    
    .process-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .process-img {
      height: 220px;
      object-fit: cover;
      transition: all 0.5s ease;
    }
    
    .process-card:hover .process-img {
      transform: scale(1.05);
    }
    
    .process-icon {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 15px;
    }
    
    .process-title {
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--text-dark);
    }
    
    /* Features Cards */
    .features-section {
      background-color: var(--lightest-bg);
      padding: 100px 0;
    }
    
    .feature-card {
      background-color: var(--white);
      border-radius: 20px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      height: 100%;
      position: relative;
      overflow: hidden;
      z-index: 1;
      border: none;
    }
    
    .feature-card::before {
      content: '';
      position: absolute;
      top: -20px;
      right: -20px;
      width: 60px;
      height: 60px;
      background-color: var(--primary);
      opacity: 0.1;
      border-radius: 50%;
      z-index: -1;
      transition: all 0.5s ease;
    }
    
    .feature-card:hover::before {
      width: 150%;
      height: 150%;
      top: -30%;
      right: -30%;
    }
    
    .feature-card:hover {
      transform: translateY(-10px);
    }
    
    .feature-icon {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }
    
    .feature-card:hover .feature-icon {
      transform: rotateY(180deg);
    }
    
    .feature-title {
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--text-dark);
    }
    
    /* Testimonials */
    .testimonial-section {
      padding: 100px 0;
      background-color: var(--secondary);
      position: relative;
      overflow: hidden;
    }
    
    .testimonial-blob {
      position: absolute;
      top: -100px;
      left: -100px;
      width: 300px;
      height: 300px;
      background-color: var(--primary);
      opacity: 0.05;
      border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
    }
    
    .testimonial-card {
      background-color: var(--white);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      margin: 20px;
    }
    
    .testimonial-text {
      font-style: italic;
      margin-bottom: 20px;
    }
    
    .testimonial-author {
      display: flex;
      align-items: center;
    }
    
    .testimonial-avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      margin-right: 15px;
      object-fit: cover;
    }
    
    .testimonial-name {
      font-weight: 600;
      margin-bottom: 0;
    }
    
    .testimonial-role {
      color: var(--primary);
      font-size: 0.9rem;
    }
    
    /* CTA Section */
    .cta-section {
      background-color: var(--primary);
      padding: 80px 0;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    
    .cta-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('/api/placeholder/1000/300') center/cover;
      opacity: 0.1;
    }
    
    .cta-content {
      position: relative;
      z-index: 2;
    }
    
    .cta-title {
      color: var(--white);
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 20px;
    }
    
    .cta-text {
      color: rgba(255, 255, 255, 0.9);
      font-size: 1.2rem;
      margin-bottom: 30px;
    }
    
    .btn-cta {
      background-color: var(--white);
      color: var(--primary);
      border: none;
      padding: 15px 40px;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .btn-cta:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      background-color: var(--white);
      color: var(--primary-dark);
    }
    
    /* Footer */
    footer {
      background-color: var(--text-dark);
      color: var(--white);
      padding: 60px 0 20px;
    }
    
    .footer-brand {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .footer-brand img {
      height: 40px;
      margin-right: 10px;
    }
    
    .footer-links h5 {
      color: var(--white);
      font-weight: 600;
      margin-bottom: 20px;
      position: relative;
      padding-bottom: 10px;
    }
    
    .footer-links h5::after {
      content: '';
      position: absolute;
      width: 40px;
      height: 3px;
      background-color: var(--primary);
      bottom: 0;
      left: 0;
    }
    
    .footer-links ul {
      list-style: none;
      padding: 0;
    }
    
    .footer-links ul li {
      margin-bottom: 10px;
    }
    
    .footer-links ul li a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .footer-links ul li a:hover {
      color: var(--primary);
      padding-left: 5px;
    }
    
    .social-icons {
      margin-top: 20px;
    }
    
    .social-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background-color: rgba(255, 255, 255, 0.1);
      color: var(--white);
      border-radius: 50%;
      margin-right: 10px;
      transition: all 0.3s ease;
    }
    
    .social-icon:hover {
      background-color: var(--primary);
      transform: translateY(-5px);
    }
    
    .footer-bottom {
      text-align: center;
      padding-top: 30px;
      margin-top: 30px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Animations and Effects */
    .floating {
      animation: floating 4s ease-in-out infinite;
    }
    
    @keyframes floating {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
      100% { transform: translateY(0px); }
    }
    
    /* Video Modal */
    .video-btn {
      display: inline-flex;
      align-items: center;
      background: transparent;
      border: none;
      color: var(--primary);
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      padding: 0;
      margin-top: 20px;
    }
    
    .video-btn i {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      background-color: var(--white);
      color: var(--primary);
      border-radius: 50%;
      margin-right: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }
    
    .video-btn:hover i {
      background-color: var(--primary);
      color: var(--white);
      transform: scale(1.1);
    }
    
    /* Carousel */
    .carousel-inner {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }
    
    .carousel-caption {
      background: rgba(0, 0, 0, 0.3);
      border-radius: 10px;
      padding: 20px;
      bottom: 40px;
    }
    
    .carousel-indicators {
      bottom: 20px;
    }
    
    .carousel-indicators button {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin: 0 5px;
      background-color: var(--white);
      opacity: 0.5;
    }
    
    .carousel-indicators .active {
      opacity: 1;
      background-color: var(--primary);
    }
    
    /* Additional styles for dark mode toggle */
    .dark-mode-toggle {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 999;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: var(--primary);
      color: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }
    
    .dark-mode-toggle:hover {
      transform: rotate(45deg);
    }
    
    /* For mobile devices */
    @media (max-width: 768px) {
      .hero-title {
        font-size: 2.5rem;
      }
      
      .hero-subtitle {
        font-size: 1.1rem;
      }
      
      .btn-custom, .btn-outline-custom {
        display: block;
        width: 100%;
        margin: 10px 0;
      }
      
      .feature-card {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="100">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="logo.png" alt="RoomieSplit Logo"> RoomieSplit
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars" style="color: white;"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#features">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#how-it-works">How It Works</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#testimonials">Testimonials</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="register.php">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section with Video Background -->
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 hero-content" data-aos="fade-right" data-aos-duration="1000">
          <h1 class="hero-title">Split Expenses, Keep Friendships</h1>
          <p class="hero-subtitle">The smart way to track, split, and settle shared expenses with roommates. No more awkward money conversations.</p>
          <div class="hero-btns">
            <a href="register.php" class="btn btn-custom">Get Started Free</a>
            <a href="#how-it-works" class="btn btn-outline-custom">See How It Works</a>
          </div>
          <!-- <button class="video-btn mt-4" data-bs-toggle="modal" data-bs-target="#demoVideo">
            <i class="fas fa-play"></i> <span>Watch Demo (2 min)</span>
          </button> -->
        </div>
        <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
          <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="6.png" class="d-block w-100 h-60" alt="App Dashboard">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Smart Dashboard</h5>
                  <p>Track all expenses in one place</p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="7.png" class="d-block w-100 h-60" alt="Bill Splitting">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Instant Splitting</h5>
                  <p>Fair divisions with a single click</p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="5.png" class="d-block w-100 h-60" alt="Mobile App">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Mobile Friendly</h5>
                  <p>Track expenses on the go</p>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="hero-shape"></div>
  </section>

  <!-- How it Works Section -->
  <section id="how-it-works" class="py-5" style="background-color: var(--lightest-bg);">
    <div class="container py-5">
      <h2 class="text-center section-title" data-aos="fade-up">How RoomieSplit Works</h2>
      <div class="row g-4">
        <!-- Step 1 -->
        <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
          <div class="process-card">
            <div class="overflow-hidden">
              <img src="2.jpg" class="process-img w-100" alt="Add Roommates">
            </div>
            <div class="card-body text-center p-4">
              <div class="process-icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <h5 class="process-title">Add Roommates</h5>
              <p class="card-text">Create your group and invite roommates with a single link to join your expense-sharing circle.</p>
            </div>
          </div>
        </div>

        <!-- Step 2 -->
        <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
          <div class="process-card">
            <div class="overflow-hidden">
              <img src="1.avif" class="process-img w-100" alt="Add Expenses">
            </div>
            <div class="card-body text-center p-4">
              <div class="process-icon">
                <i class="fas fa-receipt"></i>
              </div>
              <h5 class="process-title">Add Expenses</h5>
              <p class="card-text">Log bills, groceries, or subscriptions with our smart categorization system.</p>
            </div>
          </div>
        </div>

        <!-- Step 3 -->
        <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
          <div class="process-card">
            <div class="overflow-hidden">
              <img src="3.avif" class="process-img w-100" alt="View Balances">
            </div>
            <div class="card-body text-center p-4">
              <div class="process-icon">
                <i class="fas fa-chart-pie"></i>
              </div>
              <h5 class="process-title">View Balances</h5>
              <p class="card-text">Interactive charts show exactly who owes what with real-time updates and notifications.</p>
            </div>
          </div>
        </div>

        <!-- Step 4 -->
        <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
          <div class="process-card">
            <div class="overflow-hidden">
              <img src="4.avif" class="process-img w-100" alt="Settle Up">
            </div>
            <div class="card-body text-center p-4">
              <div class="process-icon">
                <i class="fas fa-exchange-alt"></i>
              </div>
              <h5 class="process-title">Settle Up</h5>
              <p class="card-text">Mark payments as settled with a click and keep a permanent record of all transactions.</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Video Overview -->
      <div class="row mt-5 pt-4">
        <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
          <h3 class="mb-4">See RoomieSplit in Action</h3>
          <div class="ratio ratio-16x9 rounded overflow-hidden shadow-lg">
            <!-- <img src="split.mp4" alt="Video Placeholder" class="w-100"> -->
            <video class="w-100" controls autoplay loop>
            <source src="split.mp4" type="video/mp4">
            </video>
            <!-- <div class="position-absolute top-50 start-50 translate-middle">
              <button class="btn btn-lg btn-primary rounded-circle p-3" data-bs-toggle="modal" data-bs-target="#demoVideo">
                <i class="fas fa-play"></i>
              </button>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="features-section">
    <div class="container">
      <h2 class="text-center section-title" data-aos="fade-up">Why Choose RoomieSplit?</h2>
      <div class="row g-4">
        <!-- Feature 1 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-tasks"></i>
            </div>
            <h4 class="feature-title">Smart Expense Tracking</h4>
            <p>Record, view, and edit every shared transaction with an intuitive interface designed for transparency.</p>
          </div>
        </div>
        
        <!-- Feature 2 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <h4 class="feature-title">Visualize with Charts</h4>
            <p>Interactive dashboards with real-time graphs help you understand spending patterns at a glance.</p>
          </div>
        </div>
        
        <!-- Feature 3 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-calculator"></i>
            </div>
            <h4 class="feature-title">Automated Splits</h4>
            <p>Our intelligent algorithm splits costs fairly based on your preferences—equal, percentage, or itemized.</p>
          </div>
        </div>
        
        <!-- Feature 4 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-file-pdf"></i>
            </div>
            <h4 class="feature-title">PDF Reports</h4>
            <p>Download beautifully formatted monthly reports of all expenses for your records or tax purposes.</p>
          </div>
        </div>
        
        <!-- Feature 5 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-bell"></i>
            </div>
            <h4 class="feature-title">Notification Reminders</h4>
            <p>Smart reminders ensure nobody forgets to pay their share—schedule automated payment alerts for your group.</p>
          </div>
        </div>
        
        <!-- Feature 6 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-filter"></i>
            </div>
            <h4 class="feature-title">Filters and Categories</h4>
            <p>Organize expenses by type, date, or member with advanced filtering—find what you need in seconds.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section id="testimonials" class="testimonial-section">
    <div class="container">
      <h2 class="text-center section-title" data-aos="fade-up">What Our Users Say</h2>
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="testimonial-card">
                  <div class="testimonial-text">
                    "RoomieSplit completely transformed how my roommates and I handle expenses. No more awkward money conversations or forgotten payments. The visual charts are incredibly helpful!"
                  </div>
                  <div class="testimonial-author">
                    <img src="8.png" height="80px" width="80px" class="testimonial-avatar" alt="Sarah J.">
                    <div>
                      <h5 class="testimonial-name">Sarah J.</h5>
                      <p class="testimonial-role">Graduate Student</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial-card">
                  <div class="testimonial-text">
                    "As someone who shares an apartment with 3 others, keeping track of who paid what was always a headache. RoomieSplit makes it effortless and even helps us budget better as a household."
                  </div>
                  <div class="testimonial-author">
                    <img src="9.png" height="80px" width="80px" class="testimonial-avatar" alt="Marcus T.">
                    <div>
                      <h5 class="testimonial-name">Marcus T.</h5>
                      <p class="testimonial-role">Young Professional</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial-card">
                  <div class="testimonial-text">
                    "The notification feature alone is worth it! No more chasing roommates for their share of utilities. Everything is transparent, organized, and stress-free."
                  </div>
                  <div class="testimonial-author">
                    <img src="10.png" height="80px" width="80px" class="testimonial-avatar" alt="Elena R.">
                    <div>
                      <h5 class="testimonial-name">Elena R.</h5>
                      <p class="testimonial-role">Software Developer</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="testimonial-blob"></div>
  </section>

  <!-- Stats Section -->
  <section class="py-5 bg-white">
    <div class="container py-4">
      <div class="row text-center">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="py-4">
            <i class="fas fa-users mb-3" style="font-size: 2.5rem; color: var(--primary);"></i>
            <h2 class="fw-bold mb-0 counter">50,000+</h2>
            <p class="text-muted">Active Users</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="py-4">
            <i class="fas fa-receipt mb-3" style="font-size: 2.5rem; color: var(--primary);"></i>
            <h2 class="fw-bold mb-0 counter">1.2M+</h2>
            <p class="text-muted">Expenses Tracked</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="py-4">
            <i class="fas fa-star mb-3" style="font-size: 2.5rem; color: var(--primary);"></i>
            <h2 class="fw-bold mb-0">4.8/5</h2>
            <p class="text-muted">Average Rating</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="py-5" style="background-color: var(--lightest-bg);">
    <div class="container py-5">
      <h2 class="text-center section-title" data-aos="fade-up">Frequently Asked Questions</h2>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="accordion" id="faqAccordion">
            <!-- FAQ Item 1 -->
            <div class="accordion-item border-0 mb-3 shadow-sm rounded-3" data-aos="fade-up" data-aos-delay="100">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Is RoomieSplit free to use?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Yes, RoomieSplit offers a completely free plan that covers all the essential features for up to 4 roommates. For larger groups or advanced features, we offer affordable premium plans.
                </div>
              </div>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="accordion-item border-0 mb-3 shadow-sm rounded-3" data-aos="fade-up" data-aos-delay="200">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Can I use RoomieSplit for trips with friends?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Absolutely! While designed with roommates in mind, RoomieSplit works great for splitting expenses on trips, group dinners, or any shared spending scenario.
                </div>
              </div>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="accordion-item border-0 mb-3 shadow-sm rounded-3" data-aos="fade-up" data-aos-delay="300">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  How do I invite my roommates?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Once you've created your account, you can generate an invitation link that you can share with your roommates via email, text, or any messaging app. They'll be able to join your group with just one click.
                </div>
              </div>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="accordion-item border-0 mb-3 shadow-sm rounded-3" data-aos="fade-up" data-aos-delay="400">
              <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Is my financial data secure?
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  Absolutely. RoomieSplit uses bank-level encryption and never stores your complete payment details. We don't have access to your bank accounts—we simply help you track who owes what.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-content">
        <h2 class="cta-title" data-aos="fade-up">Ready to Make Expense Sharing a Breeze?</h2>
        <p class="cta-text" data-aos="fade-up" data-aos-delay="100">Join RoomieSplit today and never argue over bills again.</p>
        <a href="register.php" class="btn btn-cta" data-aos="zoom-in" data-aos-delay="200">Get Started For Free</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
          <div class="footer-brand">
            <img src="logo.png" alt="RoomieSplit Logo">
            <h4 class="ms-2 mb-0">RoomieSplit</h4>
          </div>
          <p>Simplifying shared expenses for better living. Our mission is to make financial harmony possible for everyone sharing a living space.</p>
          <div class="social-icons">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mt-4 mt-md-0 mb-4 mb-md-0">
          <div class="footer-links">
            <h5>Company</h5>
            <ul>
              <li><a href="about.php">About Us</a></li>
              <li><a href="team.php">Our Team</a></li>
              <li><a href="careers.php">Careers</a></li>
              <li><a href="blog.php">Blog</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
          <div class="footer-links">
            <h5>Features</h5>
            <ul>
              <li><a href="#how-it-works">How It Works</a></li>
              <li><a href="#features">Our Features</a></li>
              <li><a href="pricing.php">Pricing</a></li>
              <li><a href="testimonials.php">Testimonials</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="footer-links">
            <h5>Contact Us</h5>
            <ul>
              <li><i class="fas fa-envelope me-2"></i> support@roomiesplit.com</li>
              <li><i class="fas fa-phone me-2"></i> (123) 456-7890</li>
              <li><i class="fas fa-map-marker-alt me-2"></i> 123 Finance Street, App City</li>
            </ul>
            <div class="mt-4">
              <h6>Subscribe to our newsletter</h6>
              <div class="input-group mt-3">
                <input type="email" class="form-control" placeholder="Your email" aria-label="Your email">
                <button class="btn btn-primary" type="button">Subscribe</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; <?= date("Y") ?> RoomieSplit. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Video Modal -->
  <div class="modal fade" id="demoVideo" tabindex="-1" aria-labelledby="demoVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="demoVideoLabel">RoomieSplit in Action</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="ratio ratio-16x9">
            <img src="/api/placeholder/800/450" alt="Video Placeholder" class="rounded">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Dark Mode Toggle -->
  <div class="dark-mode-toggle" id="darkModeToggle">
    <i class="fas fa-moon"></i>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      duration: 800,
      once: true
    });
    
    // Navbar Scroll Effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
      const target = parseInt(counter.innerText.replace(/,|\+/g, ''));
      const count = function() {
        const start = +counter.innerText.replace(/,|\+/g, '');
        const increment = target / 100;
        
        if (start < target) {
          counter.innerText = Math.ceil(start + increment).toLocaleString() + '+';
          setTimeout(count, 40);
        } else {
          counter.innerText = target.toLocaleString() + '+';
        }
      };
      
      // Start the animation when the element comes into view
      const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
          count();
          observer.disconnect();
        }
      }, { threshold: 0.5 });
      
      observer.observe(counter);
    });
    
    // Dark Mode functionality - just a stub for demonstration
    document.getElementById('darkModeToggle').addEventListener('click', function() {
      alert('Dark mode functionality would be implemented here!');
      this.classList.toggle('active');
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 80,
            behavior: 'smooth'
          });
        }
      });
    });
  </script>
</body>
</html>
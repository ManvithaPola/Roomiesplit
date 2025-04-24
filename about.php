<?php
$conn = mysqli_connect("localhost", "root", "", "roomiesplit");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us - RoomieSplit | Smart Expense Splitter</title>
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
    
    /* About Hero Section */
    .about-hero-section {
      padding: 180px 0 100px;
      background: linear-gradient(135deg, var(--lightest-bg) 0%, var(--light-bg) 100%);
      position: relative;
      overflow: hidden;
    }
    
    .about-hero-title {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      background: linear-gradient(90deg, var(--primary-dark), var(--primary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      position: relative;
    }
    
    .about-hero-title::after {
      content: '';
      position: absolute;
      bottom: -15px;
      left: 0;
      width: 100px;
      height: 4px;
      background-color: var(--primary);
      border-radius: 2px;
    }
    
    .about-hero-subtitle {
      font-size: 1.3rem;
      color: var(--text-dark);
      margin-bottom: 2rem;
      max-width: 700px;
    }
    
    .about-shape {
      position: absolute;
      top: -100px;
      right: -100px;
      width: 400px;
      height: 400px;
      background-color: var(--primary);
      opacity: 0.08;
      border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
      z-index: 1;
      animation: morphShape 15s ease-in-out infinite;
    }
    
    .about-shape-2 {
      position: absolute;
      bottom: -150px;
      left: -150px;
      width: 500px;
      height: 500px;
      background-color: var(--primary);
      opacity: 0.05;
      border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%;
      z-index: 1;
      animation: morphShape2 20s ease-in-out infinite;
    }
    
    @keyframes morphShape2 {
      0% {
        border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%;
      }
      50% {
        border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
      }
      100% {
        border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%;
      }
    }
    
    /* About Content Section */
    .about-content-section {
      padding: 100px 0;
      background-color: var(--lightest-bg);
      position: relative;
    }
    
    .about-card {
      background-color: var(--white);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
      position: relative;
      overflow: hidden;
      border: none;
      height: 100%;
    }
    
    .about-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--primary-dark), var(--primary));
    }
    
    .about-icon {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }
    
    .about-title {
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 20px;
      position: relative;
    }
    
    .story-subtitle {
      font-weight: 600;
      font-size: 1.2rem;
      margin-bottom: 15px;
      color: var(--primary-dark);
    }
    
    /* Mission Section */
    .mission-section {
      padding: 100px 0;
      background-color: var(--white);
      position: relative;
      overflow: hidden;
    }
    
    .mission-card {
      background-color: var(--secondary);
      border-radius: 20px;
      padding: 40px;
      margin-bottom: 30px;
      position: relative;
      overflow: hidden;
      border: none;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }
    
    .values-card {
      background-color: var(--white);
      border-radius: 20px;
      padding: 25px;
      margin-bottom: 20px;
      border: none;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
      transition: all 0.3s ease;
    }
    
    .values-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }
    
    .value-icon {
      font-size: 1.8rem;
      color: var(--primary);
      margin-bottom: 15px;
      display: inline-block;
      padding: 15px;
      background-color: var(--lightest-bg);
      border-radius: 50%;
      line-height: 1;
    }
    
    .value-title {
      font-weight: 600;
      margin-bottom: 10px;
      color: var(--text-dark);
    }
    
    /* Team Section */
    .team-section {
      padding: 100px 0;
      background-color: var(--lightest-bg);
      position: relative;
    }
    
    .section-title {
      position: relative;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 3rem;
      text-align: center;
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
    
    /* Footer from index.php stays the same */
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
    
    /* Animation */
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
    
    /* For mobile devices */
    @media (max-width: 768px) {
      .about-hero-title {
        font-size: 2.3rem;
      }
      
      .about-hero-subtitle {
        font-size: 1.1rem;
      }
      
      .about-card {
        padding: 25px;
      }
      
      .mission-card {
        padding: 25px;
      }
    }
  </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="100">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="logo.png" alt="RoomieSplit Logo"> RoomieSplit
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars" style="color: white;"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-light text-dark ms-3 px-4" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-light ms-2 px-4" href="register.php">Register</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- About Hero Section -->
  <section class="about-hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7" data-aos="fade-right" data-aos-duration="1000">
          <h1 class="about-hero-title">About RoomieSplit</h1>
          <p class="about-hero-subtitle">Simplifying shared finances for better living. We're on a mission to make expense tracking and splitting effortless for roommates worldwide.</p>
        </div>
        <div class="col-lg-5" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
          <img src="11.png" width="300px" height="200px" alt="Roommates managing expenses" class="img-fluid rounded-4 shadow">
        </div>
      </div>
    </div>
    <div class="about-shape"></div>
    <div class="about-shape-2"></div>
  </section>

  <!-- About Content Section -->
  <section class="about-content-section">
    <div class="container">
      <div class="row g-4">
        <!-- Our Story Card -->
        <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000">
          <div class="about-card h-100">
            <div class="about-icon">
              <i class="fas fa-book-open"></i>
            </div>
            <h3 class="about-title">Our Story</h3>
            <h4 class="story-subtitle">Why We Built RoomieSplit</h4>
            <p>RoomieSplit was born out of a real problem faced by our founding team. As college roommates sharing an apartment, we struggled with the monthly ritual of calculating who owed what for bills, groceries, and shared expenses.</p>
            <p>Spreadsheets were cumbersome. Text messages got lost. Payment apps didn't track who paid for what. The whole process created unnecessary tension in an otherwise great living situation.</p>
            <p>We knew there had to be a better way. So in 2023, we set out to build the simplest, most transparent expense-splitting app specifically designed for roommates — one that would make tracking shared costs as effortless as possible.</p>
          </div>
        </div>
        
        <!-- What is RoomieSplit Card -->
        <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
          <div class="about-card h-100">
            <div class="about-icon">
              <i class="fas fa-question-circle"></i>
            </div>
            <h3 class="about-title">What is RoomieSplit?</h3>
            <p>RoomieSplit is a smart expense management platform designed specifically for people sharing living spaces. Unlike generic financial apps, we focus on the unique dynamics of roommate finances.</p>
            <p>Our platform helps you:</p>
            <ul>
              <li>Track shared expenses in one centralized place</li>
              <li>Split costs fairly based on your preferences</li>
              <li>Visualize balances with intuitive charts</li>
              <li>Get automatic reminders for recurring bills</li>
              <li>Generate expense reports for transparency</li>
              <li>Settle debts within the app or via popular payment methods</li>
            </ul>
            <p>Whether you're sharing an apartment with college friends or renting with working professionals, RoomieSplit removes the financial friction from your living situation.</p>
          </div>
        </div>
        
        <!-- Who It's For Card -->
        <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
          <div class="about-card">
            <div class="about-icon">
              <i class="fas fa-users"></i>
            </div>
            <h3 class="about-title">Who RoomieSplit Is For</h3>
            <div class="row g-4 mt-3">
              <div class="col-md-4">
                <div class="values-card h-100">
                  <div class="value-icon">
                    <i class="fas fa-graduation-cap"></i>
                  </div>
                  <h4 class="value-title">College Students</h4>
                  <p>Perfect for dorm rooms, college apartments, and student housing where multiple people share expenses but are often on tight budgets.</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="values-card h-100">
                  <div class="value-icon">
                    <i class="fas fa-briefcase"></i>
                  </div>
                  <h4 class="value-title">Young Professionals</h4>
                  <p>Ideal for working adults sharing apartments in high-cost cities, where managing expenses efficiently becomes even more important.</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="values-card h-100">
                  <div class="value-icon">
                    <i class="fas fa-home"></i>
                  </div>
                  <h4 class="value-title">Any Shared Living</h4>
                  <p>Whether you're sharing with family members, short-term rentals, or in co-living spaces, RoomieSplit adapts to your unique living arrangement.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mission and Values Section -->
  <section class="mission-section">
    <div class="container">
      <h2 class="section-title" data-aos="fade-up">Our Mission & Values</h2>
      <div class="row">
        <div class="col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="100">
          <div class="mission-card text-center mb-5">
            <div class="about-icon">
              <i class="fas fa-bullseye"></i>
            </div>
            <h3 class="about-title">Our Mission</h3>
            <p class="mb-0">To eliminate financial tension from shared living situations by creating the most transparent, fair, and easy-to-use expense splitting solution in the world.</p>
          </div>
        </div>
      </div>
      
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-hand-holding-heart"></i>
            </div>
            <h4 class="value-title">Fairness</h4>
            <p>We believe expense sharing should be transparent and equitable for everyone involved.</p>
          </div>
        </div>
        
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-lightbulb"></i>
            </div>
            <h4 class="value-title">Simplicity</h4>
            <p>Financial tools should be intuitive and accessible, not complicated or intimidating.</p>
          </div>
        </div>
        
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h4 class="value-title">Trust</h4>
            <p>We build features that foster trust between roommates through transparency and clear communication.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Key Features Section -->
  <section class="team-section">
    <div class="container">
      <h2 class="section-title" data-aos="fade-up">Key Features</h2>
      <div class="row g-4">
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-tasks"></i>
            </div>
            <h4 class="value-title">Smart Expense Tracking</h4>
            <p>Log, categorize, and organize shared expenses with our intuitive interface.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-calculator"></i>
            </div>
            <h4 class="value-title">Fair Splitting Options</h4>
            <p>Split equally, by percentage, or with custom amounts based on your agreement.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-chart-pie"></i>
            </div>
            <h4 class="value-title">Visual Dashboards</h4>
            <p>See who owes what with clear visual reports and interactive charts.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-file-export"></i>
            </div>
            <h4 class="value-title">Export Options</h4>
            <p>Download expense reports as CSV or PDF for your records or tax purposes.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-bell"></i>
            </div>
            <h4 class="value-title">Smart Reminders</h4>
            <p>Automatic notifications for bills due, unpaid balances, and payment confirmations.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <h4 class="value-title">Mobile Friendly</h4>
            <p>Access your expenses and balances on any device, anytime, anywhere.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-history"></i>
            </div>
            <h4 class="value-title">Transaction History</h4>
            <p>Complete searchable history of all expenses, payments, and settlements.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
          <div class="values-card text-center h-100">
            <div class="value-icon">
              <i class="fas fa-lock"></i>
            </div>
            <h4 class="value-title">Secure & Private</h4>
            <p>Your financial data stays private and secure with bank-level encryption.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-5" style="background-color: var(--primary);">
    <div class="container py-4 text-center">
      <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
          <h2 class="text-white mb-4">Ready to simplify your shared expenses?</h2>
          <p class="text-white mb-4 opacity-90">Join thousands of roommates who've eliminated money stress from their shared living experience.</p>
          <a href="register.php" class="btn btn-light px-4 py-3 fw-bold">Get Started For Free</a>
        </div>
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
              <li><a href="index.php#how-it-works">How It Works</a></li>
              <li><a href="index.php#features">Our Features</a></li>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    // Initialize AOS animation library
    AOS.init({
      once: true,
      duration: 800,
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        document.querySelector('.navbar').classList.add('scrolled');
      } else {
        document.querySelector('.navbar').classList.remove('scrolled');
      }
    });
  </script>
  </body>
  </html>
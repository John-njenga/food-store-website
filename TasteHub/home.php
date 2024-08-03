<?php
session_start();

// Logout functionality
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>TASTELOGIC</title>
  <style>
    /* Reset and base styles */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      background-color: #f7f7f7;
      color: #333;
    }
    
    /* Header styles */
    header {
      background-color: #ffd700;
      padding: 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    nav {
      display: flex;
      gap: 1rem;
    }

    nav a {
      color: #333;
      text-decoration: none;
      font-weight: bold;
      padding: 0.5rem 1rem;
      transition: background-color 0.3s;
    }

    nav a:hover {
      background-color: #fff176;
      border-radius: 5px;
    }

    header img {
      height: 40px;
    }
    
    .search-input {
      padding: 0.5rem;
      justify-content: center;
      border-radius: 20px;
      border: 1px solid #ccc;
      width: 300px;
      font-size: 14px;
      margin-left: 150px;
    }
    
    .get-started-btn {
      background-color: #00796b;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
    }
    
    .get-started-btn:hover {
      background-color: #004d40;
    }
    
    .logout-btn {
      background-color: #e53935;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    
    .logout-btn:hover {
      background-color: #c62828;
    }
    
    /* Main content section */
    .main-content {
      padding: 2rem;
      text-align: center;
    }
    
    .food-item {
      display: inline-block;
      text-align: center;
      background-color: #fff;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 0.5rem;
      transition: transform 0.3s ease;
      margin-left: 25px;
      margin-right: 15px;
      cursor: pointer;
    }
    
    .food-item:hover {
      transform: translateY(-5px);
    }
    
    .food-item img {
      max-width: 100px;
      border-radius: 50%;
      margin-bottom: 0.5rem;
    }
    
    .food-item p {
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
    }
    
    .food-item a {
      background-color: white;
      color: black;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      text-decoration: none;
      display: inline-block;
      margin-top: 0.5rem;
      transition: background-color 0.3s ease;
    }
    
    .food-item a:hover {
      background-color: yellow;
    }
    
    /* Cart section */
    .cart {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #fff;
      border-radius: 10px;
      padding: 1rem;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 300px;
      display: none; /* Initially hide the cart */
    }
    
    .cart h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }
    
    .cart ul {
      padding: 0;
      list-style-type: none;
    }
    
    .cart-item {
      margin-bottom: 0.5rem;
    }
    
    /* Stores section */
    .stores {
      background-color: #fff;
      padding: 3rem 0;
      text-align: center;
      display: flex;
      margin: 15px;
      justify-content: center;
    }
    
    .store-item {
      display: inline-block;
      text-align: center;
      width: 150px;
      padding: 1rem;
      margin: 0.5rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      margin-left: 25px;
      cursor: pointer;
    }
    
    .store-item:hover {
      transform: translateY(-5px);
    }
    
    .store-item .discount {
      background-color: #ffcc80;
      color: #ff5722;
      padding: 0.25rem 0.5rem;
      border-radius: 20px;
      margin-bottom: 0.5rem;
      font-weight: bold;
    }
    
    .store-item p {
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
    }
    
    .store-item-image {
      max-width: 100%;
      border-radius: 10px 10px 0 0; /* Rounded corners for the top */
    }
    
    /* Rider section */
    .rider {
      background-color: #c8e6c9;
      padding: 4rem 0;
      text-align: center;
    }
    
    .rider img {
      width: 100px;
      border-radius: 50%;
      margin-bottom: 1rem;
    }
    
    .rider h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }
    
    .rider p {
      font-size: 1.1rem;
      margin-bottom: 1rem;
    }
    
    .rider button {
      background-color: #1976d2;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 25px;
      border: none;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    
    .rider button:hover {
      background-color: #0d47a1;
    }
    
    /* Footer styles */
    footer {
      background-color: #333;
      color: #fff;
      padding: 2rem 0;
      text-align: center;
    }
    
    footer ul {
      list-style-type: none;
      padding: 0;
    }
    
    footer ul li {
      margin-bottom: 0.5rem;
    }
    
    footer a {
      color: #fff;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    
    footer a:hover {
      color: #ffd700;
    }
    footer .contact-details {
      margin-bottom: 1rem;
    }
    footer .contact-details p {
      margin: 0.5rem 0;
    }
    footer .contact-details p span {
      font-weight: bold;
    }
    footer .contact-details p i {
      margin-right: 0.5rem;
    }
    footer .social-media {
      margin-top: 1rem;
    }
    footer .social-media a {
      color: #fff;
      text-decoration: none;
      margin: 0 1rem;
      transition: color 0.3s ease;
      font-size: 1.5rem;
    }
    footer .social-media a:hover {
      color: #ffd700;
    }
    
    /* Banner section styles */
.banner {
  position: relative;
  background: url('images/a.png') no-repeat center center/cover; /* Replace with your background image */
  height: 500px;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 0 1rem;
  overflow: hidden; /* Ensure content does not overflow */
}

.banner-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
  display: flex;
  align-items: center;
  justify-content: center;
}

.banner-content {
  z-index: 1;
  max-width: 800px;
  position: relative; /* Ensure content is positioned relative to banner */
}

.banner h1 {
  font-size: 3rem;
  margin-bottom: 1rem;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
  animation: moveUpDown 3s ease-in-out infinite; /* Apply animation */
}

.banner p {
  font-size: 1.2rem;
  margin-bottom: 1.5rem;
  line-height: 1.4;
}

.banner .cta-btn {
  background-color: #ff5722;
  color: #fff;
  padding: 0.75rem 1.5rem;
  border-radius: 25px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.banner .cta-btn:hover {
  background-color: #e64a19;
}

/* Keyframes for the up and down movement */
@keyframes moveUpDown {
  0% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-20px); /* Move up */
  }
  100% {
    transform: translateY(0); /* Move back to original position */
  }
}

  </style>
</head>
<body>
<header>
    <div class="header-left">
    <div class="text-3xl font-bold text-teal-600 mr-4">TASTELOGIC
    <img src="https://static.vecteezy.com/system/resources/previews/006/487/588/non_2x/hand-drawn-yummy-face-tongue-smile-delicious-icon-logo-vector.jpg" class="h-10">
    </div>
    </div>
    <nav>
        <a href="home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="track_order.php">TrackOrder</a>
        <a href="#contactus">Contact</a>
        <a href="login.php">Login</a>
        <form method="post" style="display: inline;">
      <button type="submit" name="logout" class="logout-btn">Logout</button>
    </form>
    <a href="admin_login.php">Admin</a> <!-- Admin Button -->
    </nav>
   
</header>

<section class="banner">
    <div class="banner-overlay">
        <div class="banner-content">
            <h1>Welcome to TASTELOGIC</h1>
            <p>Your one-stop destination for delicious and authentic cuisines.</p>
            <a href="menu.php" class="cta-btn">Explore Menu</a>
        </div>
    </div>
</section>

<div class="main-content">
    <h2>Our Popular Dishes</h2>
    <div class="food-item">
        <img src="images/pasta.jpg" alt="Food 1">
        <p>Spaghetti Bolognese</p>
        <a href="#">Order Now</a>
    </div>
    <div class="food-item">
        <img src="images/Chicken Stew Rice.jpg" alt="Food 2">
        <p>Chicken Curry</p>
        <a href="#">Order Now</a>
    </div>
    <div class="food-item">
        <img src="images/grilled pork chops.jpg" alt="Food 3">
        <p>Grilled Steak</p>
        <a href="#">Order Now</a>
    </div>
</div>

<section>
  <h2 class="text-2xl font-bold mb-4">Stores you might like</h2>

  <div class="stores">
    <div class="food-item" id="kfc-items">
      <img src="https://ling-app.com/wp-content/uploads/2022/03/Swahili-Foods.jpg" alt="Swahili dishes Logo" class="store-item-image">
      <p>Swahili Dishes</p>
    </div>
    <div class="food-item" id="kfc-food-items">
      <img src="https://tb-static.uber.com/prod/image-proc/processed_images/69e921fab7408f91e98bf8031c6f2f47/fb86662148be855d931b37d6c1e5fcbe.jpeg" alt="Chicken and Fries" class="store-item-image">
      <a href="https://chickeninn.co.ke/">Chicken Inn</a>
    </div>

    <div class="food-item" id="kfc-food-items">
      <img src="https://tb-static.uber.com/prod/image-proc/processed_images/f57fb461cfafbbb63b57e8a50c81c5d0/c9252e6c6cd289c588c3381bc77b1dfc.jpeg" alt="KFC Item" class="store-item-image">
      <a href="https://kfc.ke/en/menu">KFC</a>
    </div>

    <div class="food-item" id="kfc-food-items">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT39Y-dCdNlDHEF6FuI9fiT3hI4733BGeqcxA&s" alt="Chicken and Fries">
      <a href="https://naivas.online/naivas-bakery/deli-snacks">Naivas Cafe</a>
    </div>

    <div class="food-item" id="kfc-food-items">
      <img src="https://www.artcaffe.co.ke/images/Artlife/Artcaffe-Britam-7.webp" alt="Artcaffe Item" class="store-item-image">
      <a href="https://www.artcaffe.co.ke/order#/menu">ARTCAFE</a>
    </div>

    <div class="food-item" id="kfc-food-items">
      <img src="https://tb-static.uber.com/prod/image-proc/processed_images/ce900df222a1167abca92c2aa56e456a/fb86662148be855d931b37d6c1e5fcbe.jpeg" alt="Pizza Inn Item" class="store-item-image">
      <a href="https://pizzainn.co.ke/product-category/classic-pizzas/">Pizza Inn</a>
    </div>
  </div>
</section>
<section class="rider">
    <h3>Become a Rider</h3>
    <p>Join our team and start earning by delivering delicious food.</p>
    <button>Apply Now</button>
</section>

<footer>
    <ul>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Terms of Service</a></li>
    </ul>
    <div class="container" id="contactus">
    <div class="contact-details">
    <p><span>Contact Us:</span></p>
      <p><i class="fas fa-phone-alt"></i><span>Phone:</span> +254 796 886423</p>
      <p><i class="fas fa-envelope"></i><span>Email:</span> contact@tastelogic.com</p>
    </div>
    <div class="social-media">
      <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
      <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
      <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
      <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
    </div>
  </div>
  </div>
    <p>&copy; 2024 TASTELOGIC. All rights reserved.</p>
</footer>
</body>
</html>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Admin Dashboard - TASTELOGIC</title>
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

    .dashboard-item {
      display: inline-block;
      text-align: center;
      background-color: #fff;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 0.5rem;
      transition: transform 0.3s ease;
      cursor: pointer;
    }

    .dashboard-item:hover {
      transform: translateY(-5px);
    }

    .dashboard-item img {
      max-width: 100px;
      border-radius: 50%;
      margin-bottom: 0.5rem;
    }

    .dashboard-item p {
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
    }

    .dashboard-item a {
      background-color: white;
      color: black;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      text-decoration: none;
      display: inline-block;
      margin-top: 0.5rem;
      transition: background-color 0.3s ease;
    }

    .dashboard-item a:hover {
      background-color: yellow;
    }
    
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
       
        <form method="post" style="display: inline;">
          <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    </nav>
</header>

<div class="main-content">
    <h2>Admin Dashboard</h2>
    <div class="dashboard-item">
        <img src="images/useric.jpg" alt="Manage Users">
        <p>Manage Users</p>
        <a href="admin_users.php">View</a>
    </div>
    <div class="dashboard-item">
        <img src="images/menuic.jpg" alt="Manage Menu">
        <p>Manage Menu</p>
        <a href="additem.php">View</a>
    </div>
    <div class="dashboard-item">
        <img src="images/oderic.png" alt="View Order">
        <p>Order management</p>
        <a href="admin_view.php">View</a>
    </div>
    <div class="dashboard-item">
        <img src="images/statusic.jpg" alt="Update Order status">
        <p>Update Order Status</p>
        <a href="update_status.php">View</a>
    </div>
</div>


</body>
</html>

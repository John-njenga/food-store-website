<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - TASTELOGIC</title>
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
      align-items: center;
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
      border-radius: 20px;
      border: 1px solid #ccc;
      width: 300px;
      font-size: 14px;
      margin-left: 20px;
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

    .cart-icon {
      display: flex;
      align-items: center;
      position: relative;
      cursor: pointer;
    }

    .cart-icon img {
      height: 30px;
    }

    .cart-count {
      position: absolute;
      top: -10px;
      right: -10px;
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem;
      font-weight: bold;
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
    
    .food-item button {
      background-color: #00796b;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      text-decoration: none;
      display: inline-block;
      margin-top: 0.5rem;
      transition: background-color 0.3s ease;
      border: none;
      cursor: pointer;
    }
    
    .food-item button:hover {
      background-color: #004d40;
    }
  </style>
</head>
<body>

<header>
  <div class="text-3xl font-bold text-teal-600 mr-4">TASTELOGIC
    <img src="https://static.vecteezy.com/system/resources/previews/006/487/588/non_2x/hand-drawn-yummy-face-tongue-smile-delicious-icon-logo-vector.jpg" class="h-10">
  </div>

  <nav>
    <a href="admin_dashboard.php">Back</a>
  </nav>
</header>

<div class="main-content">
  <h1 class="text-3xl font-bold mb-4">Add New Item</h1>

  <form action="add.php" method="POST">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required><br><br>
    <label for="category">Category:</label>
    <input type="text" id="category" name="category" required><br><br>
    <label for="price">Price (KES):</label>
    <input type="number" id="price" name="price" required><br><br>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required><br><br>
    <label for="image_url">Image URL:</label>
    <input type="text" id="image_url" name="image_url" required><br><br>
    <button type="submit">Add Item</button>
  </form>

  <h1 class="text-3xl font-bold mb-4">Current Menu</h1>

  <?php
  // Database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "taste";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch products from the database
  $sql = "SELECT product_id, product_name, category, price, quantity, image FROM product_list";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
      echo '<div class="food-item">';
      echo '<img src="' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">';
      echo '<p>' . htmlspecialchars($row["product_name"]) . '</p>';
      echo '<p>Category: ' . htmlspecialchars($row["category"]) . '</p>';
      echo '<p>Price: KES ' . number_format($row["price"], 2) . '</p>';
      echo '<p>Quantity: ' . htmlspecialchars($row["quantity"]) . '</p>';
      echo '<form action="update.php" method="POST">';
      echo '<input type="hidden" name="productid" value="' . htmlspecialchars($row["product_id"]) . '">';
      echo '<label for="product_name">Product Name:</label>';
      echo '<input type="text" id="product_name" name="product_name" value="' . htmlspecialchars($row["product_name"]) . '" required><br><br>';
      echo '<label for="category">Category:</label>';
      echo '<input type="text" id="category" name="category" value="' . htmlspecialchars($row["category"]) . '" required><br><br>';
      echo '<label for="price">Price (KES):</label>';
      echo '<input type="number" id="price" name="price" value="' . htmlspecialchars($row["price"]) . '" required><br><br>';
      echo '<label for="quantity">Quantity:</label>';
      echo '<input type="number" id="quantity" name="quantity" value="' . htmlspecialchars($row["quantity"]) . '" required><br><br>';
      echo '<label for="image_url">Image URL:</label>';
      echo '<input type="text" id="image_url" name="image_url" value="' . htmlspecialchars($row["image"]) . '" required><br><br>';
      echo '<button type="submit">Update Item</button>';
      echo '</form>';
      echo '<form action="delete.php" method="POST">';
      echo '<input type="hidden" name="productid" value="' . htmlspecialchars($row["product_id"]) . '">';
      echo '<button type="submit">Delete Item</button>';
      echo '</form>';
      echo '</div>';
    }
  } else {
    echo "No items found";
  }

  $conn->close();
  ?>

</div>

</body>
</html>

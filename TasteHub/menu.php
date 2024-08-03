<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - TASTELOGIC</title>
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
    <input type="text" placeholder="Search" class="search-input" id="searchInput">
  </div>

  <nav>
    <a href="home.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="home.php#contactus">Contact</a>
    <div class="cart-icon">
      <a href="cart_list.php">
        <img src="images/cart.png" alt="Cart Icon">
        <span class="cart-count" id="cartCount"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
      </a>
    </div>
  </nav>
</header>

<div class="main-content">
  <h1 class="text-3xl font-bold mb-4">Our Menu</h1>

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
  $sql = "SELECT product_name, price, image FROM product_list";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
      $productName = htmlspecialchars($row["product_name"]);
      echo '<div class="food-item" data-name="' . $productName . '">';
      echo '<img src="' . htmlspecialchars($row["image"]) . '" alt="' . $productName . '">';
      echo '<p>' . $productName . '</p>';
      echo '<p>KES ' . number_format($row["price"], 2) . '</p>';
      echo '<form class="add-to-cart-form">';
      echo '<input type="hidden" name="name" value="' . $productName . '">';
      echo '<input type="hidden" name="price" value="' . htmlspecialchars($row["price"]) . '">';
      echo '<input type="number" name="quantity" value="1" min="1" class="quantity-input" style="width: 80px;">';
      echo '<button type="submit" class="add-to-cart-btn">Add to Cart</button>';
      echo '</form>';
      echo '</div>';
    }
  } else {
    echo "0 results";
  }

  // Close connection
  $conn->close();
  ?>
</div>

<script>
  document.getElementById('searchInput').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    document.querySelectorAll('.food-item').forEach(item => {
      const itemName = item.getAttribute('data-name').toLowerCase();
      if (itemName.includes(filter)) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  });

  // Function to update the cart count in the header
  function updateCartCount(count) {
    document.getElementById('cartCount').textContent = count;
  }

  // Add event listeners to all forms
  document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', event => {
      event.preventDefault(); // Prevent the default form submission behavior

      const formData = new FormData(form);
      fetch('add_to_cart.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Update cart count
          updateCartCount(data.cartCount);
        } else {
          console.error('Failed to add item to cart');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  });
</script>

</body>
</html>
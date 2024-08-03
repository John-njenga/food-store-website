<?php
session_start();
$username = $_SESSION['username'] ?? '';  // Retrieve the username from the session

// Remove item from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['name'])) {
    $itemName = $_GET['name'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['name'] == $itemName) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
            break;
        }
    }
}

// Database connection
$servername = "localhost";
$dbusername = "root";
$password = "";
$dbname = "taste";

$conn = new mysqli($servername, $dbusername, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Save cart items to database when proceeding to checkout
if (isset($_POST['proceed_to_checkout'])) {
    $cartItems = $_SESSION['cart'];

    foreach ($cartItems as $item) {
        $name = $conn->real_escape_string($item['name']);
        $price = $item['price'];
        $quantity = $item['quantity'];
        $total = $price * $quantity;

        $sql = "INSERT INTO cart (username, product_name, price, quantity, total) VALUES ('$username', '$name', '$price', '$quantity', '$total')";
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Clear the cart after saving to database
    $_SESSION['cart'] = [];
    header("Location: checkout.php"); // Redirect to a success page
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart - TASTELOGIC</title>
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

    .cart-list {
      background-color: #fff;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 0 auto;
      max-width: 800px;
    }

    .cart-list h1 {
      margin-bottom: 1rem;
      font-size: 2rem;
      color: #00796b;
    }

    .cart-list table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1rem;
    }

    .cart-list th, .cart-list td {
      padding: 0.5rem;
      border-bottom: 1px solid #ddd;
    }

    .cart-list th {
      background-color: #00796b;
      color: white;
    }

    .cart-list .total {
      font-weight: bold;
      text-align: right;
    }

    .cart-list .checkout-btn {
      background-color: #00796b;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      margin-top: 1rem;
      display: inline-block;
    }

    .cart-list .checkout-btn:hover {
      background-color: #004d40;
    }
    
    .remove-btn {
      background-color: #e53935;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    
    .remove-btn:hover {
      background-color: #c62828;
    }
  </style>
</head>
<body>

<header>
  <div class="text-3xl font-bold text-teal-600 mr-4">TASTELOGIC
    <img src="https://static.vecteezy.com/system/resources/previews/006/487/588/non_2x/hand-drawn-yummy-face-tongue-smile-delicious-icon-logo-vector.jpg" class="h-10">
  </div>

  <nav>
    <a href="home.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="#">About</a>
    <a href="#">Contact</a>
    <div class="cart-icon">
      <a href="cart_list.php">
        <img src="images/cart.png" alt="Cart Icon">
        <span class="cart-count" id="cartCount"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
      </a>
    </div>
  </nav>
</header>

<div class="main-content">
  <div class="cart-list">
    <h1>Cart</h1>
    <?php
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
      echo '<form method="POST" action="">';
      echo '<table>';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Product</th>';
      echo '<th>Price</th>';
      echo '<th>Quantity</th>';
      echo '<th>Total</th>';
      echo '<th>Action</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      $totalAmount = 0;

      foreach ($_SESSION['cart'] as $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $totalAmount += $itemTotal;
        echo '<tr>';
        echo '<td>' . htmlspecialchars($item['name']) . '</td>';
        echo '<td>KES ' . number_format($item['price'], 2) . '</td>';
        echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
        echo '<td>KES ' . number_format($itemTotal, 2) . '</td>';
        echo '<td><a href="cart_list.php?action=remove&name=' . urlencode($item['name']) . '" class="remove-btn">Remove</a></td>';
        echo '</tr>';
      }

      echo '<tfoot>';
      echo '<tr>';
      echo '<td colspan="3" class="total">Total</td>';
      echo '<td class="total">KES ' . number_format($totalAmount, 2) . '</td>';
      echo '</tr>';
      echo '</tfoot>';

      echo '</tbody>';
      echo '</table>';
      echo '<button type="submit" name="proceed_to_checkout" class="checkout-btn">Proceed to Checkout</button>';
      echo '</form>';

    } else {
      echo '<p>Your cart is empty.</p>';
    }
    ?>
  </div>
</div>

</body>
</html>

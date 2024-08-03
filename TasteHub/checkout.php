<?php
session_start();
$username = $_SESSION['username'] ?? '';

// Initialize cart items array
$cartItemsArray = [];

// Check if user is logged in and fetch the most recent cart item
if ($username) {
    // Database connection
    $mysqli = new mysqli("localhost", "root", "", "taste");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Fetch the most recent cart item for the user
    $stmt = $mysqli->prepare("
        SELECT product_name, price, quantity, total 
        FROM cart 
        WHERE username = ? 
        ORDER BY created_at DESC 
        LIMIT 1
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $cartItemsArray[] = [
            'name' => $row['product_name'],
            'price' => $row['price'],
            'quantity' => $row['quantity'],
            'total' => $row['total']
        ];
    }

    $stmt->close();
    $mysqli->close();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $address = $_POST['address'] ?? '';
    $cartItems = $_POST['cart_items'] ?? '';

    // Generate a random order number
    $orderNumber = uniqid('ORDER-');

    // Database connection
    $mysqli = new mysqli("localhost", "root", "", "taste");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Insert or update user details in the info table along with the order number
    $stmt = $mysqli->prepare("
        INSERT INTO info (username, first_name, last_name, email, mobile, address, cart_items, order_number) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE first_name = VALUES(first_name), last_name = VALUES(last_name), email = VALUES(email), mobile = VALUES(mobile), address = VALUES(address), cart_items = VALUES(cart_items), order_number = VALUES(order_number)
    ");
    $stmt->bind_param("ssssssss", $username, $firstName, $lastName, $email, $mobile, $address, $cartItems, $orderNumber);

    if ($stmt->execute()) {
        // Insert order tracking details
        $stmtTracking = $mysqli->prepare("
            INSERT INTO order_tracking (order_number, username, status, created_at) 
            VALUES (?, ?, 'Pending', NOW())
        ");
        $stmtTracking->bind_param("ss", $orderNumber, $username);
        if (!$stmtTracking->execute()) {
            echo "Error inserting into order_tracking: " . $stmtTracking->error;
        }
        $stmtTracking->close();

        // Clear previous cart items for the user
        $stmt = $mysqli->prepare("DELETE FROM cart WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->close();

        // Store the current cart item in the cart table
        $cartItemsArray = json_decode($cartItems, true);
        if ($cartItemsArray && is_array($cartItemsArray)) {
            foreach ($cartItemsArray as $item) {
                $productName = $item['name'];
                $productPrice = $item['price'];
                $productQuantity = $item['quantity'];
                $productTotal = $item['total'];
                $stmt = $mysqli->prepare("INSERT INTO cart (username, product_name, price, quantity, total, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt->bind_param("ssdii", $username, $productName, $productPrice, $productQuantity, $productTotal);
                $stmt->execute();
            }
        }
        header('Location: lipa.php');  // Redirect to lipa.php
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - TASTELOGIC</title>
  <style>
    /* Reset and base styles */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; line-height: 1.6; background-color: #f7f7f7; color: #333; }
    header { background-color: #ffd700; padding: 1rem; display: flex; justify-content: space-between; align-items: center; }
    header img { height: 40px; }
    .checkout-form { margin-top: 2rem; padding: 1rem; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px; margin-left: auto; margin-right: auto; }
    .checkout-form h4 { font-size: 1.5rem; margin-bottom: 1rem; text-align: center; }
    .checkout-form .form-group { margin-bottom: 1rem; }
    .checkout-form label { font-weight: bold; display: block; margin-bottom: 0.5rem; }
    .checkout-form input, .checkout-form textarea { width: 100%; padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 5px; }
    .checkout-form button { background-color: #00796b; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; border: none; font-weight: bold; cursor: pointer; transition: background-color 0.3s ease; display: block; width: 100%; margin-top: 1rem; }
    .checkout-form button:hover { background-color: #004d40; }
    footer { background-color: #333; color: #fff; padding: 2rem 0; text-align: center; margin-top: 2rem; }
    footer ul { list-style-type: none; padding: 0; }
    footer ul li { margin-bottom: 0.5rem; }
    footer a { color: #fff; text-decoration: none; transition: color 0.3s ease; }
    footer a:hover { color: #ffd700; }
  </style>
</head>
<body>

<header>
  <div class="text-3xl font-bold text-teal-600 mr-4">TASTELOGIC
    <img src="https://static.vecteezy.com/system/resources/previews/006/487/588/non_2x/hand-drawn-yummy-face-tongue-smile-delicious-icon-logo-vector.jpg" class="h-10">
  </div>
</header>

<div class="checkout-form">
  <h4>Confirm Delivery Information</h4>
  <form action="" method="POST">
    <div class="form-group">
      <label for="first_name">First Name</label>
      <input type="text" name="first_name" id="first_name" required class="form-control">
    </div>
    <div class="form-group">
      <label for="last_name">Last Name</label>
      <input type="text" name="last_name" id="last_name" required class="form-control">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required class="form-control">
    </div>
    <div class="form-group">
      <label for="mobile">Contact</label>
      <input type="text" name="mobile" id="mobile" required class="form-control">
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <textarea name="address" id="address" cols="30" rows="3" required class="form-control"></textarea>
    </div>
    
     <!-- Hidden inputs -->
     <input type="hidden" name="cart_items" id="cart_items" value='<?php echo htmlspecialchars(json_encode($cartItemsArray)); ?>'>
    <input type="hidden" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
    <button type="submit" class="btn btn-outline-dark">Proceed to Payment</button>
  </form>
</div>

<footer>
  <div>
    <p class="text-3xl bold mb-8">LET'S DO THIS TOGETHER</p>
  </div>
  <div>
    <p class="font-bold mb-2">Links of Interest</p>
    <ul>
      <li><a href="#">About Us</a></li>
    </ul>
  </div>
  <div>
    <p class="font-bold mb-2">Terms & Conditions</p>
    <ul>
      <li><a href="#">Privacy Policy</a></li>
      <li><a href="#">Cookies Policy</a></li>
    </ul>
  </div>
</footer>

</body>
</html>
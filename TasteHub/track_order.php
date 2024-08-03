<?php
// Start session if needed
session_start();

// Database connection
$mysqli = new mysqli("localhost", "root", "", "taste");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize variables
$orderNumber = '';
$orderDetails = [];
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderNumber = $_POST['order_number'] ?? '';

    // Validate the order number
    if (!empty($orderNumber)) {
        // Fetch order details from the order_tracking table
        $stmt = $mysqli->prepare("
            SELECT o.order_number, o.status, o.created_at, i.first_name, i.last_name, i.email, i.mobile, i.address, i.cart_items
            FROM order_tracking o
            JOIN info i ON o.order_number = i.order_number
            WHERE o.order_number = ?
        ");
        $stmt->bind_param("s", $orderNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $orderDetails = $result->fetch_assoc();
        } else {
            $errorMessage = "Order not found. Please check the order number and try again.";
        }

        $stmt->close();
    } else {
        $errorMessage = "Please enter a valid order number.";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order</title>
    <style>
        /* Add your styles here */
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 50px; }
        .container h2 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .form-group button { width: 100%; padding: 10px; background-color: #00796b; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
        .form-group button:hover { background-color: #004d40; }
        .order-details { margin-top: 20px; }
        .order-details h3 { margin-bottom: 10px; }
        .order-details p { margin: 5px 0; }
        .error-message { color: red; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
    <nav>
        <a href="home.php">Back</a>
    </nav>
<div class="container">
    <h2>Track Your Order</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="order_number">Enter your Order Number</label>
            <input type="text" id="order_number" name="order_number" required>
        </div>
        <div class="form-group">
            <button type="submit">Track Order</button>
        </div>
    </form>

    <?php if (!empty($orderDetails)): ?>
        <div class="order-details">
            <h3>Order Details</h3>
            <p><strong>Order Number:</strong> <?php echo htmlspecialchars($orderDetails['order_number']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($orderDetails['status']); ?></p>
            <p><strong>Placed On:</strong> <?php echo htmlspecialchars($orderDetails['created_at']); ?></p>
            <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($orderDetails['first_name'] . ' ' . $orderDetails['last_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($orderDetails['email']); ?></p>
            <p><strong>Mobile:</strong> <?php echo htmlspecialchars($orderDetails['mobile']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($orderDetails['address']); ?></p>
            <h4>Items Ordered:</h4>
            <?php
            $cartItems = json_decode($orderDetails['cart_items'], true);
            if ($cartItems && is_array($cartItems)) {
                echo '<ul>';
                foreach ($cartItems as $item) {
                    echo '<li>' . htmlspecialchars($item['name']) . ' - Quantity: ' . htmlspecialchars($item['quantity']) . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No items found.</p>';
            }
            ?>
        </div>
    <?php elseif (!empty($errorMessage)): ?>
        <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>
</div>
</body>
</html>

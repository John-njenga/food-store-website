<?php
session_start();

// Database connection
$mysqli = new mysqli("localhost", "root", "", "taste");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get username from session
$username = $_SESSION['username'] ?? '';

// Initialize the order number variable
$orderNumber = '';

if ($username) {
    // Fetch the latest order number for the user from the info table
    $stmt = $mysqli->prepare("SELECT order_number FROM info WHERE username = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $orderNumber = $row['order_number'];
    }

    $stmt->close();
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout Success - TASTELOGIC</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      background-color: #f7f7f7;
      color: #333;
      text-align: center;
      padding: 2rem;
    }

    .success-message {
      background-color: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: 0 auto;
    }

    .success-message h1 {
      font-size: 2rem;
      color: #00796b;
    }

    .success-message p {
      font-size: 1rem;
      margin: 1rem 0;
    }

    .success-message a {
      color: #00796b;
      text-decoration: none;
      font-weight: bold;
    }

    .success-message a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="success-message">
  <h1>Checkout Successful!</h1>
  <p>Your cart items have been saved and your order has been placed.</p>
  <?php if ($orderNumber): ?>
    <p><strong>Order Number:</strong> <?php echo htmlspecialchars($orderNumber); ?></p>
    <p>Please keep this number for your records and use it to track your order.</p>
  <?php else: ?>
    <p>There was an issue retrieving your order number. Please contact support.</p>
  <?php endif; ?>
  <a href="home.php">Return to Home</a>
</div>

</body>
</html>

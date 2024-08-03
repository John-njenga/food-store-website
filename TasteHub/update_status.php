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
$newStatus = '';
$successMessage = '';
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderNumber = $_POST['order_number'] ?? '';
    $newStatus = $_POST['status'] ?? '';

    // Validate input
    if (!empty($orderNumber) && !empty($newStatus)) {
        // Update order status in the order_tracking table
        $stmt = $mysqli->prepare("UPDATE order_tracking SET status = ? WHERE order_number = ?");
        $stmt->bind_param("ss", $newStatus, $orderNumber);

        if ($stmt->execute()) {
            $successMessage = "Order status updated successfully.";
        } else {
            $errorMessage = "Error updating order status: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $errorMessage = "Please provide both order number and status.";
    }
}

// Fetch all orders for display
$orders = [];
$stmt = $mysqli->prepare("SELECT order_number, status, created_at FROM order_tracking");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$stmt->close();

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <style>
        /* Add your styles here */
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 50px; }
        .container h2 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .form-group button { width: 100%; padding: 10px; background-color: #00796b; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
        .form-group button:hover { background-color: #004d40; }
        .success-message { color: green; text-align: center; margin-top: 10px; }
        .error-message { color: red; text-align: center; margin-top: 10px; }
        .order-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .order-table th, .order-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        .order-table th { background-color: #00796b; color: white; }
        .order-table tr:nth-child(even) { background-color: #f2f2f2; }
        .order-table button { background-color: #00796b; color: white; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; }
        .order-table button:hover { background-color: #004d40; }
    </style>
</head>
<body>
    <nav>
        <a href="admin_dashboard.php">Back</a>
    </nav>
<div class="container">
    <h2>Update Order Status</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="order_number">Order Number</label>
            <input type="text" id="order_number" name="order_number" value="<?php echo htmlspecialchars($orderNumber); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">New Status</label>
            <select id="status" name="status" required>
                <option value="" disabled>Select status</option>
                <option value="Pending" <?php echo $newStatus == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="In Transit" <?php echo $newStatus == 'In Transit' ? 'selected' : ''; ?>>In Transit</option>
                <option value="Delivered" <?php echo $newStatus == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                <option value="Cancelled" <?php echo $newStatus == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit">Update Status</button>
        </div>
    </form>

    <?php if (!empty($successMessage)): ?>
        <p class="success-message"><?php echo htmlspecialchars($successMessage); ?></p>
    <?php elseif (!empty($errorMessage)): ?>
        <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>

    <table class="order-table">
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Status</th>
                <th>Placed On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                    <td>
                        <button onclick="editOrder('<?php echo htmlspecialchars($order['order_number']); ?>')">Edit</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function editOrder(orderNumber) {
    document.getElementById('order_number').value = orderNumber;
}
</script>
</body>
</html>

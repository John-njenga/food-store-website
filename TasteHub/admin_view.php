<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "taste");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch data from info table
$sql = "SELECT username, first_name, last_name, email, mobile, address, cart_items, created_at FROM info";
$result = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order Table</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: yellow;
            color: black;
            padding: 1rem;
            text-align: center;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background: yellow;
            color: #000;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .cart-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .cart-items li {
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1>View Order</h1>

        <nav style="display: flex;">
            <a href="admin_dashboard.php">Back</a>
        </nav>
    </header>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Cart Items</th>
                    <th>Added On</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";

                        // Decode cart_items JSON
                        $cartItems = json_decode($row['cart_items'], true);
                        echo "<td>";
                        if ($cartItems && is_array($cartItems)) {
                            echo "<ul class='cart-items'>";
                            foreach ($cartItems as $item) {
                                $name = htmlspecialchars($item['name']);
                                $price = number_format($item['price'], 2);
                                $quantity = htmlspecialchars($item['quantity']);
                                echo "<li>Item: $name | Price: Kes$price | Quantity: $quantity</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "No items";
                        }
                        echo "</td>";

                        // Display added timestamp
                        $added_on = htmlspecialchars($row['created_at']);
                        echo "<td>$added_on</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Close the database connection
$mysqli->close();
?>

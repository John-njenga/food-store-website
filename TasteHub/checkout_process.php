<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $cart_items = $_POST['cart_items'];
    $username = $_POST['username'];

    // Decode cart items from JSON
    $cartItems = json_decode($cart_items, true);

    // Insert order into the `orders` table
    $stmt = $conn->prepare("INSERT INTO orders (username, first_name, last_name, email, mobile, address, cart_items) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $first_name, $last_name, $email, $mobile, $address, $cart_items);

    if ($stmt->execute()) {
        // Clear the cart after order is placed
        $stmt = $conn->prepare("DELETE FROM cart WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        echo 1;  // Order placed successfully
    } else {
        echo 0;  // Order failed
    }

    $stmt->close();
    $conn->close();
}
?>

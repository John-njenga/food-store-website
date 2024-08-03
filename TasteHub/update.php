<?php
session_start();

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $product_id = $_POST['productid'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image_url = $_POST['image_url'];

    // Update data in the database
    $sql = "UPDATE product_list SET product_name = ?, category = ?, price = ?, quantity = ?, image = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssi", $product_name, $category, $price, $quantity, $image_url, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Item updated successfully'); window.location.href = 'additem.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'additem.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

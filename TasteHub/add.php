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

// Function to generate a unique random primary key
function generateRandomPrimaryKey($conn) {
    $random_id = rand(1, 999); // Adjust range as needed

    // Check if the random ID already exists
    $check_sql = "SELECT COUNT(*) as count FROM product_list WHERE product_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $random_id);
    $stmt->execute();
    $stmt->bind_result($conn);
    $stmt->fetch();
    $stmt->close();

    // If the ID already exists, generate a new one
    if ($conn > 0) {
        return generateRandomPrimaryKey($conn);
    }

    return $random_id;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $image_url = $_POST['image_url'];

    // Generate a unique random primary key
    $product_id = generateRandomPrimaryKey($conn);

    // Insert data into the database
    $sql = "INSERT INTO product_list (product_id, product_name, category, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdss", $product_id, $product_name, $category, $price, $quantity, $image_url);

    if ($stmt->execute()) {
        echo "<script>alert('New item added successfully'); window.location.href = 'additem.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'additem.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

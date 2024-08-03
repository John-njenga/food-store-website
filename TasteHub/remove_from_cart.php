<?php
session_start();

if (isset($_POST['index'])) {
  $index = intval($_POST['index']);
  
  // Check if index is valid
  if (isset($_SESSION['cart'][$index])) {
    // Remove the item from the cart
    unset($_SESSION['cart'][$index]);
    // Re-index the cart array to ensure the indices are sequential
    $_SESSION['cart'] = array_values($_SESSION['cart']);
  }
}

// Redirect back to the cart page
header('Location: cart_list.php');
exit();
?>

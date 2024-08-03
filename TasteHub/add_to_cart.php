<?php
session_start();

$response = array('success' => false);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if (!empty($name) && $price > 0 && $quantity > 0) {
        $item = array(
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        );

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Check if the item already exists in the cart
        $itemFound = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['name'] == $name) {
                $cartItem['quantity'] += $quantity;
                $itemFound = true;
                break;
            }
        }

        if (!$itemFound) {
            $_SESSION['cart'][] = $item;
        }

        $response['success'] = true;
        $response['cartCount'] = count($_SESSION['cart']);
    }
}

echo json_encode($response);
?>

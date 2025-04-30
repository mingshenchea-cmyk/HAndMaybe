<?php
require '_base.php';
//-----------------------------------------------------------------------------

$user_id = $_SESSION['user_id'];
$cart_id = null;
$variation_id = post('variation_id');
$quantity = 1;

if (!$user_id) {
    // If not logged in, redirect to login page
    header('Location: ../page/login.php');
    exit;
}

// Check if user already has a cart
$stmt = $_db->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);  // Bind $user_id to the query
$cart = $stmt->fetch();  // Fetch the result

if (!$cart) {
    $stmt = $_db->prepare("INSERT INTO cart (user_id, created_at) VALUES (?, NOW())");
    $stmt->execute([$user_id]);

    // Get the last inserted cart_id
    $cart_id = $_db->lastInsertId();
} else {
    $cart_id = $cart->cart_id;
}

// Check if product already exists in cart_items
$stmt = $_db->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND variation_id = ?");
$stmt->execute([$cart_id, $variation_id]);
$cart_item = $stmt->fetch();

if ($cart_item) {
    // If item exists, update quantity
    $stmt = $_db->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE cart_item_id = ?");
    $stmt->execute([$quantity, $cart_item->cart_item_id]);

    // Set success message for updating quantity
    $_SESSION['cart_message'] = "Item quantity updated in your cart.";
} else {
    // If item not exists, insert new item
    $stmt = $_db->prepare("INSERT INTO cart_items (cart_id, variation_id, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$cart_id, $variation_id, $quantity]);

    
    // Set success message for adding new item
    $_SESSION['cart_message'] = "Item added to your cart.";
}

// Redirect back to product page or cart page
header('Location: ../page/product_detail.php');
exit;
?>
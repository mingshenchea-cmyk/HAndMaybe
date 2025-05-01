<?php
include '../../_base.php';
require '../../vendor/autoload.php';
auth('Member');

$session_id = get('session_id') ?? null;

if (!$session_id || !isset($_SESSION['checkout'])) {
    temp('error', 'Invalid payment session.');
    redirect('/');
}

$stripe = new \Stripe\StripeClient('sk_test_51RJdlCRsIa8xRBa153QoHVIciO8voGAe3wzHMz4sLYpJPOQF2S01AdUmOMhXaLW8nJMZpChvhT8RAH60z9Fyh8v500hewKjjRs');

try {
    $session = $stripe->checkout->sessions->retrieve($session_id);

    if ($session->payment_status !== 'paid') {
        temp('error', 'Payment not completed.');
        redirect('/page/cart/checkout.php');
        exit();
    }

    $address = $_SESSION['checkout']['address'];
    $user_id = $_user->user_id;

    $stm = $_db->prepare('
        SELECT * FROM cart WHERE user_id = ?'
    );
    $stm->execute([$_user->user_id]);
    $user_cart = $stm->fetch();

    $stm = $_db->prepare('
        SELECT * FROM cart_items WHERE cart_id = ?'
    );
    $stm->execute([$user_cart->cart_id]);
    $cart = $stm->fetchAll();

    $stm = $_db->prepare('
        SELECT * FROM address WHERE user_id = ?'
    );
    $stm->execute([$_user->user_id]);
    $address = $stm->fetch();
    $address_id = $address->address_id;

    $shipping_fee = 10.00;
    $total_amount = 0;
    foreach ($cart as $item) {
        $variation_id = $item->variation_id;
        $quantity = $item->quantity;
        $stm = $_db->prepare('
            SELECT p.price 
            FROM product p 
            JOIN product_variation pv 
            ON p.product_id = pv.product_id 
            WHERE pv.variation_id = ?
        ');
        $stm->execute([$variation_id]);
        $product = $stm->fetch();
        if ($product) {
            $total_amount += $product->price * $quantity;
        }
    }
    $total_amount += $shipping_fee;

    $stm = $_db->prepare('
        INSERT INTO `order` (user_id, created_at, status, shipping_fee, total_amount, address_id)
        VALUES (?, NOW(), "Pending", ?, ?, ?)
    ');
    $stm->execute([$user_id, $shipping_fee, $total_amount, $address_id]);
    $order_id = $_db->lastInsertId();

    $stm = $_db->prepare('
        INSERT INTO order_items (order_id, variation_id, quantity)
        VALUES (?, ?, ?)
    ');
    foreach ($cart as $item) {
        $variation_id = $item->variation_id;
        $quantity = $item->quantity;
        $stmProd = $_db->prepare('
            SELECT p.product_id 
            FROM product p 
            JOIN product_variation pv 
            ON p.product_id = pv.product_id 
            WHERE pv.variation_id = ?
        ');
        $stmProd->execute([$variation_id]);
        $product = $stmProd->fetch();
        if ($product) {
            $stm->execute([$order_id, $item->variation_id, $quantity]);
        }
    }

    $deleteCartItems = $_db->prepare('
        DELETE FROM cart_items WHERE cart_id = ?'
    );
    $deleteCartItems->execute([$user_cart->cart_id]);

    temp('info', 'Order Success');
    redirect('/');

} catch (\Exception $e) {
    // Log the exception for debugging
    error_log("Stripe API Error: " . $e->getMessage()); // Log it to the server's error log
    temp('error', 'Could not verify payment: ' . $e->getMessage());
    redirect('/');
}

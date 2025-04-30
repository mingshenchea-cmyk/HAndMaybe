<?php
include '../../_base.php';

$stm = $_db->prepare('
            INSERT INTO address (user_id, address_line1, city, state, postal_code, country)
            VALUES (?, ?, ?, ?, ?, ?)
        ');
$stm->execute([$user_id, $address_line1, $city, $state, $postal_code, $country]);
$address_id = $_db->lastInsertId();

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
    INSERT INTO order_items (order_id, product_id, quantity)
    VALUES (?, ?, ?)
');
foreach ($cart as $variation_id => $item) {
    $quantity = is_array($item) ? $item['quantity'] : $item;
    $stmProd = $_db->prepare('
        SELECT p.product_id FROM product p JOIN product_variation pv ON p.product_id = pv.product_id WHERE pv.variation_id = ?
    ');
    $stmProd->execute([$variation_id]);
    $product = $stmProd->fetch();
    if ($product) {
        $stm->execute([$order_id, $product->product_id, $quantity]);
    }
}

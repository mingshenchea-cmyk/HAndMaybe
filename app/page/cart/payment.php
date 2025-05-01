<?php
include '../../_base.php';

auth('Member');

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
$shipping_fee = 10.00; 

$total = 0;
$products = [];
foreach ($cart as $item) {
    $variation_id = $item->variation_id;
    $quantity = $item->quantity;
    $cart_query = $_db->prepare('
        SELECT p.product_id, p.name, p.description, p.price, pv.color, pv.size, pv.product_photo
        FROM product p
        JOIN product_variation pv ON p.product_id = pv.product_id
        WHERE pv.variation_id = ?
    ');
    $cart_query->execute([$variation_id]);
    $product = $cart_query->fetch();
    
    if ($product) {
        $subtotal = $product->price * $quantity;
        $total += $subtotal;

        $products[] = [
            "price_data" => [
                'currency' => 'myr',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => $product->price * 100,
            ],
            "quantity" => $quantity,
        ];
    }
}

$products[] = [
    "price_data" => [
        'currency' => 'myr',
        'product_data' => [
            'name' => 'Shipping Fee',
        ],
        'unit_amount' => $shipping_fee * 100,
    ],
    "quantity" => 1,
];

require '../../vendor/autoload.php';
$stripe = new \Stripe\StripeClient("sk_test_51RJdlCRsIa8xRBa153QoHVIciO8voGAe3wzHMz4sLYpJPOQF2S01AdUmOMhXaLW8nJMZpChvhT8RAH60z9Fyh8v500hewKjjRs");

try {
    $checkout_session = $stripe->checkout->sessions->create([
        'payment_method_types' => ['card'],
        'line_items' => $products,
        'mode' => 'payment',
        'success_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/page/cart/payment_success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/page/cart/checkout.php',
        'metadata' => [
            'user_id' => $_user->user_id,
        ],
    ]);

    header("Location: " . $checkout_session->url);
    exit();
} catch (\Stripe\Exception\ApiErrorException $e) {
    $_err['payment'] = 'There was an error processing your payment. Please try again.';
    temp('error', $_err['payment']);
    redirect('/');
}

?>

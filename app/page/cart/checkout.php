<?php
include '../../_base.php';
auth('Member');

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

if (!$cart) redirect('shopping_cart.php');

if(is_get()) {
$stm = $_db->prepare('
    SELECT * FROM address WHERE user_id = ?'
    );
    $stm->execute([$_user->user_id]);
    $address = $stm->fetch();

    if ($address) {
        extract((array)$address);
        $_SESSION['has_address'] = True;
    } else {
        $_SESSION['has_address'] = False;
    }
}

if (is_post()) {
    $address_line1 = req('address_line1');
    $city = req('city');
    $state = req('state');
    $postal_code = req('postal_code');
    $country = req('country');
    $shipping_fee = 10.00;

    if (!$address_line1 || !$city || !$state || !$postal_code || !$country) {
        $_err['address'] = 'All address fields are required.';
    }

    if (!$_err) {
        $_SESSION['checkout'] = [
            'address' => [
                'address_line1' => $address_line1,
                'city' => $city,
                'state' => $state,
                'postal_code' => $postal_code,
                'country' => $country
            ]
        ];

        if (!$_SESSION['has_address']) {
            $stm = $_db->prepare('
                INSERT INTO address (user_id, address_line1, city, state, postal_code, country)
                VALUES (?, ?, ?, ?, ?, ?)
            ');
            $stm->execute([$user_id, $address_line1, $city, $state, $postal_code, $country]);
        } else {
            $stm = $_db->prepare('
                UPDATE address 
                SET address_line1 = ?, city = ?, state = ?, postal_code = ?, country = ?
                WHERE user_id = ? 
            ');
            $stm->execute([$address_line1, $city, $state, $postal_code, $country, $user_id]);
        }

        redirect("payment.php");
    }
}

$stm = $_db->prepare('SELECT name, email, phone_no FROM user WHERE user_id = ?');
$stm->execute([$user_id]);
$user = $stm->fetch();

$cart_items = [];
$total = 0;
$total_items = 0;
$shipping_fee = 10.00;
$stm = $_db->prepare('
    SELECT p.product_id, p.name, p.description, p.price, pv.color, pv.size, pv.product_photo
    FROM product p
    JOIN product_variation pv ON p.product_id = pv.product_id
    WHERE pv.variation_id = ?
');
foreach ($cart as $variation_id => $item) {
    $variation_id = $item->variation_id;
    $quantity = $item->quantity;
    $stm->execute([$variation_id]);
    $product = $stm->fetch();
    if ($product) {
        $subtotal = $product->price * $quantity;
        $total += $subtotal;
        $total_items += $quantity;
        $cart_items[] = [
            'photo' => $product->product_photo,
            'name' => $product->name,
            'description' => $product->description,
            'color' => $product->color,
            'size' => $product->size,
            'price' => $product->price,
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
    }
}

// ----------------------------------------------------------------------------
$_title = 'Checkout';
include '../../_head.php';
?>
<link rel="stylesheet" href="/css/checkout.css">

<div class="checkout-container">
    <form method="post" class="checkout-form">
        <div class="checkout-left">
            <h2>Your Info</h2>
            <p><strong>Name:</strong> <?= $user->name ?></p>
            <p><strong>Email:</strong> <?= $user->email ?></p>
            <p><strong>Phone:</strong> <?= $user->phone_no ?></p>

            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

            <h3>Shipping Address</h3>
            <label>Address Line 1:</label>
            <?= html_text('address_line1', 'required') ?>
            <label>City:</label>
            <?= html_text('city', 'required') ?>
            <label>State:</label>
            <?= html_text('state', 'required') ?>
            <label>Postal Code:</label>
            <?= html_text('postal_code', 'required') ?>
            <label>Country:</label>
            <?= html_text('country', 'required') ?>
            <?= err('address') ?>
        </div>

        <div class="checkout-right">
            <div class="summary-header">
                <h2>Order Summary</h2>
                <a href="shopping_cart.php" class="edit-cart-btn">Edit Cart</a>
            </div>

            <?php foreach ($cart_items as $item): ?>
                <div class="checkout-item">
                    <img src="/images/<?= $item['photo'] ?>" class="checkout-item-photo">
                    <div class="checkout-item-info">
                        <h4><?= $item['name'] ?></h4>
                        <p><?= $item['description'] ?></p>
                        <p>Color: <?= $item['color'] ?> | Size: <?= $item['size'] ?></p>
                        <p>Price: RM<?= number_format($item['price'], 2) ?></p>
                        <p>Quantity: <?= $item['quantity'] ?></p>
                        <p><strong>Subtotal: RM<?= number_format($item['subtotal'], 2) ?></strong></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="checkout-summary">
                <p>Total Items: <?= $total_items ?></p>
                <p>Subtotal: RM<?= number_format($total, 2) ?></p>
                <p>Shipping Fee: RM<?= number_format($shipping_fee, 2) ?></p>
                
                <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

                <h3>Total: RM<?= number_format($total + $shipping_fee, 2) ?></h3>
                <button type="submit" class="pay-btn">Pay Now</button>
            </div>
        </div>
    </form>
</div>

<?php include '../../_foot.php'; ?>

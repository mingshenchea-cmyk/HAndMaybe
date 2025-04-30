<?php
require '../../_base.php';

auth('Member');

if (is_post()) {
    $btn = req('btn');
    if ($btn == 'clear') {
        set_cart();
        redirect('?');
    } else if ($btn == 'remove') {
        $variation_id = req('variation_id');
        $cart = get_cart();
        unset($cart[$variation_id]);
        set_cart($cart);
        redirect();
    }

    $variation_id = req('variation_id');
    $quantity = req('quantity');
    update_cart($variation_id, $quantity);
    redirect();
}

$_title = 'My Cart';

include '../../_head.php';
?>
<link rel="stylesheet" href="/css/shoppingcart.css">

<div class="shopping-cart">
    <h1 class="cart-header">My Cart</h1>

    <?php
    $total = 0;
    $total_items = 0;
    $shipping_fee = 10.00;
    $cart = get_cart();

    $cart_query = $_db->prepare('
        SELECT 
            p.product_id, p.name, p.description, p.price,
            pv.variation_id, pv.color, pv.size, pv.product_photo, pv.stock_quantity
        FROM product p
        JOIN product_variation pv ON p.product_id = pv.product_id
        WHERE pv.variation_id = ?
    ');

    if (empty($cart)): ?>
        <p class="empty-cart">Your cart is empty.</p>
        <div class="browse-link-wrapper">
            <a href="/page/product/product.php" class="browse-link-btn">Browse Products</a>
        </div>
    <?php else: ?>
        <?php foreach ($cart as $variation_id => $item):
            $quantity = is_array($item) ? $item['quantity'] : $item;
            $cart_query->execute([$variation_id]);
            $product = $cart_query->fetch();
            if (!$product) continue;

            $subtotal = $product->price * $quantity;
            $total += $subtotal;
            $total_items += $quantity;
        ?>
            <div class="cart-item">
                <div class="cart-item-left">
                    <img src="/images/<?= $product->product_photo ?>" alt="<?= $product->name ?>" class="cart-item-image">
                    <div class="cart-item-details">
                        <h2 class="cart-item-title"><?= $product->name ?></h2>
                        <p class="description"><?= $product->description ?></p>
                        <p class="cart-item-variant">
                            <strong>Color:</strong> <?= $product->color ?> |
                            <strong>Size:</strong> <?= $product->size ?>
                        </p>
                        <p class="cart-item-price">Price: RM<?= number_format($product->price, 2) ?></p>
                        <form method="post" class="remove-form">
                            <input type="hidden" name="variation_id" value="<?= $variation_id ?>">
                            <button type="submit" name="btn" value="remove" class="remove-btn">Remove</button>
                        </form>
                    </div>
                </div>
                <div class="cart-item-right">
                    <div class="quantity-selector">
                        <span class="quantity-label">Quantity:</span>
                        <form method="post" class="quantity-form">
                            <input type="hidden" name="variation_id" value="<?= $variation_id ?>">
                            <select name="quantity" class="quantity-input">
                                <?php
                                $max_qty = min(10, $product->stock_quantity);
                                for ($qty = 1; $qty <= $max_qty; $qty++): ?>
                                    <option value="<?= $qty ?>" <?= $qty == $quantity ? 'selected' : '' ?>>
                                        <?= $qty ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </form>
                    </div>
                    <p class="cart-item-subtotal"><strong>Subtotal:</strong> RM<?= number_format($subtotal, 2) ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="order-summary">
            <h3 class="summary-title">Cart Summary</h3>

            <div class="summary-row">
                <span class="summary-label">Total Items</span>
                <span class="summary-value"><?= $total_items ?></span>
            </div>

            <div class="summary-row">
                <span class="summary-label">Subtotal</span>
                <span class="summary-value">RM<?= number_format($total, 2) ?></span>
            </div>

            <div class="summary-row">
                <span class="summary-label">Shipping Fee</span>
                <span class="summary-value">RM<?= number_format($shipping_fee, 2) ?></span>
            </div>

            <div class="estimated-total">
                <div class="summary-row">
                    <span>Estimated Total</span>
                    <span>RM<?= number_format($total + $shipping_fee, 2) ?></span>
                </div>
            </div>

            <div class="cart-actions">
                <button data-post="?btn=clear" class="clear-btn">Clear Cart</button>
                <button data-post="checkout.php" class="checkout-btn">Proceed to Checkout</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    $(function () {
        $('.quantity-input').on('change', function () {
            $(this).closest('form').submit();
        });
    });
</script>

<?php include '../../_foot.php'; ?>

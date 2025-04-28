<?php
require '../_base.php';

// ----------------------------------------------------------------------------
// Handle Cart Updates
// ----------------------------------------------------------------------------

if (is_post()) {
    $btn = req('btn');
    if ($btn == 'clear') {
        set_cart();
        redirect('?'); 
    }

    $variation_id = req('variation_id');
    $quantity = req('quantity');
    update_cart($variation_id, $quantity);
    redirect(); 
}

// ----------------------------------------------------------------------------
// Display Shopping Cart
// ----------------------------------------------------------------------------

$_title = 'My Cart';
include '../_head.php';

// Check if user is logged in
$is_member = isset($_SESSION['user_id']) && $_SESSION['role'] == 'Member';
?>
<link rel="stylesheet" href="/path/to/cart.css">

<div class="cart-container">
    <h1 class="cart-header">My Cart</h1>

    <?php
    $total = 0;
    $cart = get_cart();
    
    // Single optimized query to get all product and variation details
    $cart_query = $_db->prepare('
        SELECT p.product_id, p.name, p.price, p.description,
               pv.variation_id, pv.color, pv.size, pv.product_photo, pv.stock_quantity
        FROM product_variation pv
        JOIN product p ON pv.product_id = p.product_id
        WHERE pv.variation_id = ?
    ');

    if (empty($cart)): ?>
        <p class="empty-cart">Your cart is empty</p>
    <?php else: ?>
        <?php foreach ($cart as $variation_id => $item):
            // Get quantity
            $quantity = is_array($item) ? $item['quantity'] : $item;
            
            // Get product and variation details
            $cart_query->execute([$variation_id]);
            $item_details = $cart_query->fetch();
            
            if (!$item_details) continue; // Skip if not found
            
            $subtotal = $item_details->price * $quantity;
            $total += $subtotal;
        ?>
            <div class="cart-item">
                <img src="<?= htmlspecialchars($item_details->product_photo) ?>" 
                     alt="<?= htmlspecialchars($item_details->name) ?>" 
                     class="cart-item-image">
                <div class="cart-item-details">
                    <h2 class="cart-item-title"><?= htmlspecialchars($item_details->name) ?></h2>
                    <p class="cart-item-variant">
                        Color: <?= htmlspecialchars($item_details->color) ?> | 
                        Size: <?= htmlspecialchars($item_details->size) ?>
                    </p>
                    <p class="cart-item-price">Each RM<?= number_format($item_details->price, 2) ?></p>
                    
                    <div class="quantity-selector">
                        <span class="quantity-label">Quantity:</span>
                        <form method="post" class="quantity-form">
                            <input type="hidden" name="variation_id" value="<?= htmlspecialchars($variation_id) ?>">
                            <select name="quantity" class="quantity-input">
                                <?php 
                                $max_qty = min(10, $item_details->stock_quantity);
                                for ($qty = 1; $qty <= $max_qty; $qty++): ?>
                                    <option value="<?= $qty ?>" <?= $qty == $quantity ? 'selected' : '' ?>>
                                        <?= $qty ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </form>
                    </div>
                    
                    <p class="cart-item-subtotal">Subtotal: RM<?= number_format($subtotal, 2) ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Promo Code Section -->
        <div class="promo-section">
            <h3 class="promo-title">ENTER PROMO CODE</h3>
            <form class="promo-input-group">
                <input type="text" class="promo-input" placeholder="Promo Code">
                <button type="submit" class="promo-submit">Submit</button>
            </form>
        </div>
        
        <!-- Order Summary -->
        <div class="order-summary">
            <h3 class="summary-title">Order Summary</h3>
            
            <div class="summary-row">
                <span class="summary-label">Subtotal</span>
                <span class="summary-value">RM<?= number_format($total, 2) ?></span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Shipping</span>
                <span class="summary-value">TBD</span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Discount</span>
                <span class="summary-value">RM0.00</span>
            </div>
            
            <div class="estimated-total">
                <div class="summary-row">
                    <span>Estimated Total</span>
                    <span>RM<?= number_format($total, 2) ?></span>
                </div>
            </div>
            
            <div class="cart-actions">
                <?php if (!empty($cart)): ?>
                    <button data-post="?btn=clear" class="clear-btn">Clear Cart</button>
                    
                    <?php if ($is_member): ?>
                        <button data-post="checkout.php" class="checkout-btn">Proceed to Checkout</button>
                    <?php else: ?>
                        <p class="login-prompt">Please <a href="/login.php">login</a> as member to checkout</p>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    $(function() {
        $('.quantity-input').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>

<?php
include '../_foot.php';
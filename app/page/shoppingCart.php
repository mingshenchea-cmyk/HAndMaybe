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
    
    // Prepare queries
    $product_stm = $_db->prepare('SELECT * FROM product WHERE product_id = ?');
    $variation_stm = $_db->prepare('SELECT * FROM product_variation WHERE variation_id = ?');

    if (empty($cart)): ?>
        <p class="empty-cart">Your cart is empty</p>
    <?php else: ?>
        <?php foreach ($cart as $variation_id => $item):
            // Get quantity - handle both array and simple value formats
            $quantity = is_array($item) ? $item['quantity'] : $item;
            
            // Get variation details
            $variation_stm->execute([$variation_id]);
            $variation = $variation_stm->fetch();
            
            if (!$variation) continue;
            
            // Get product details
            $product_stm->execute([$variation->product_id]);
            $product = $product_stm->fetch();
            
            if (!$product) continue;
            
            $subtotal = $product->price * $quantity;
            $total += $subtotal;
        ?>
            <div class="cart-item">
                <img src="<?= htmlspecialchars($variation->product_photo) ?>" alt="<?= htmlspecialchars($product->name) ?>" class="cart-item-image">
                <div class="cart-item-details">
                    <h2 class="cart-item-title"><?= htmlspecialchars($product->name) ?></h2>
                    <p class="cart-item-variant">
                        Color: <?= htmlspecialchars($variation->color) ?> | 
                        Size: <?= htmlspecialchars($variation->size) ?>
                    </p>
                    <p class="cart-item-price">Each RM<?= number_format($product->price, 2) ?></p>
                    
                    <div class="quantity-selector">
                        <span class="quantity-label">Quantity:</span>
                        <form method="post" class="quantity-form">
                            <input type="hidden" name="variation_id" value="<?= htmlspecialchars($variation_id) ?>">
                            <select name="quantity" class="quantity-input">
                                <?php foreach (range(1, 10) as $qty): ?>
                                    <option value="<?= $qty ?>" <?= $qty == $quantity ? 'selected' : '' ?>>
                                        <?= $qty ?>
                                    </option>
                                <?php endforeach; ?>
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
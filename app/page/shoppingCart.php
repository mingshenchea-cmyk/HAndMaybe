<?php
require '../_base.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $btn = req('btn');
    if ($btn == 'clear') {
        set_cart();
        redirect('?'); 
    }

    $id = req('id');
    $unit = req('unit');
    update_cart($id, $unit);
    redirect(); 
}

// ----------------------------------------------------------------------------

$_title = 'My Cart';
include '../_head.php';
?>
<link rel="stylesheet" href="/path/to/cart.css">

<div class="cart-container">
    <h1 class="cart-header">My Cart</h1>

    <?php
    $count = 0;
    $total = 0;
    $cart = get_cart();
    $stm = $_db->prepare('SELECT * FROM product WHERE id = ?');

    if (empty($cart)): ?>
        <p class="empty-cart">Your cart is empty</p>
    <?php else: ?>
        <?php foreach ($cart as $id => $unit):
            $stm->execute([$id]);
            $p = $stm->fetch();
            $subtotal = $p->price * $unit;
            $count += $unit;
            $total += $subtotal;
        ?>
            <div class="cart-item">
                <img src="/products/<?= encode($p->photo) ?>" alt="<?= encode($p->name) ?>" class="cart-item-image">
                <div class="cart-item-details">
                    <h2 class="cart-item-title"><?= encode($p->name) ?></h2>
                    <p class="cart-item-price">Each RM<?= number_format($p->price, 2) ?></p>
                    
                    <div class="quantity-selector">
                        <span class="quantity-label">Quantity:</span>
                        <form method="post" class="quantity-form">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <select name="unit" class="quantity-input">
                                <?php foreach (range(1, 10) as $i): ?>
                                    <option value="<?= $i ?>" <?= $i == $unit ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endforeach ?>
                            </select>
                        </form>
                    </div>
                    
                    <p class="cart-item-price">Subtotal: RM<?= number_format($subtotal, 2) ?></p>
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
                <?php if ($cart): ?>
                    <button data-post="?btn=clear" class="clear-btn">Clear Cart</button>
                    
                    <?php if ($_user?->role == 'Member'): ?>
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
        $('select').on('change', function(e) {
            e.target.form.submit();
        });
    });
</script>

<?php
include '../_foot.php';
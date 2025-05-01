<?php
require '../../_base.php';
// ----------------------------------------------------------------------------
auth('Member');

// Handle cancel request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_order_id'])) {
    $order_id = $_POST['cancel_order_id'];

    $cancel_stm = $_db->prepare('
        UPDATE `order`
        SET status = "cancelled"
        WHERE order_id = ? AND user_id = ?
    ');
    $cancel_stm->execute([$order_id, $_user->user_id]);

    header('Location: order_history.php');
    exit;
}

$stm = $_db->prepare('
    SELECT o.*, 
           a.address_line1, a.city, a.state, a.postal_code, a.country
    FROM `order` o
    JOIN address a ON o.address_id = a.address_id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
');
$stm->execute([$_user->user_id]);
$orders = $stm->fetchAll();

//-----------------------------------------------------------------------------
$_title = 'Order History';
include '../../_head.php';
?>
<link rel="stylesheet" href="/css/orderhistory.css">

<div class="order-history-container">
    <h1>My Order History</h1>

    <?php if (empty($orders)): ?>
        <p>You haven't placed any orders yet.</p>
        <div class="browse-link-wrapper">
            <a href="/page/product/product.php" class="browse-link-btn">Browse Products</a>
        </div>
    <?php else: ?>
        <?php
        $item_query = $_db->prepare('
            SELECT oi.quantity,
                   pv.color, pv.size, pv.product_photo,
                   p.name 
            FROM order_items oi
            JOIN product_variation pv ON oi.variation_id = pv.variation_id
            JOIN product p ON pv.product_id = p.product_id
            WHERE oi.order_id = ?
        ');
        ?>

        <?php foreach ($orders as $order): ?>
            <?php
            $item_query->execute([$order->order_id]);
            $items = $item_query->fetchAll();
            $created_at = new DateTime($order->created_at);
            $estimated = clone $created_at;
            $estimated->modify('+7 days'); // Estimated delivery is always 7 days after order date
            ?>
            <div class="order-card">
                <!-- product details-->
                <div class="order-items">
                    <h3>Items</h3>
                    <?php foreach ($items as $item): ?>
                        <div class="order-item">
                            <img src="/images/<?= $item->product_photo ?>" alt="<?= $item->name ?>" class="cart-item-image">
                            <div class="item-details">
                                <strong><?= $item->name ?></strong>
                                <div>Size: <?= $item->size ?></div>
                                <div>Color: <?= $item->color ?></div>
                                <div>Quantity: <?= $item->quantity ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="total-amount">Total Paid: RM<?= number_format($order->total_amount, 2) ?></div>
                </div>

                <!-- Shipping info -->
                <div class="order-shipping">
                    <h4>Shipping Info</h4>
                    <p><?= $order->address_line1 ?></p>
                    <p><?= $order->city ?>, <?= $order->state ?></p>
                    <p><?= $order->postal_code ?>, <?= $order->country ?></p>
                </div>

                <!--Status -->
                <div class="order-status">
                    <div class="status <?= $order->status === 'cancelled' ? 'cancelled' : '' ?>">
                        <?= ucfirst($order->status) ?>
                    </div>

                    <?php if ($order->status !== 'cancelled'): ?>
                        <div class="estimated">
                            ETA: <?= $estimated->format('M d, Y') ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($order->status !== 'cancelled'): ?>
                        <form method="POST" class="cancel-form" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                            <input type="hidden" name="cancel_order_id" value="<?= $order->order_id ?>">
                            <button type="submit" class="cancel-btn">Cancel Order</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../../_foot.php'; ?>

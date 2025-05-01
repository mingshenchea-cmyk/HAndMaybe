<?php
require '../../_base.php';

auth('Member');

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

// ----------------------------------------------------------------------------
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
            ?>
            <div class="order-card">
                <!-- Product Details -->
                <div class="order-items">
                    <h3>Items</h3>
                    <?php foreach ($items as $item): ?>
                        <div class="order-item">
                            <span><strong><?= $item->name ?></strong></span>
                            <span>Size: <?= $item->size ?></span>
                            <span>Color: <?= $item->color ?></span>
                            <span>Quantity: <?= $item->quantity ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="total-amount">Total Paid: RM<?= number_format($order->total_amount, 2) ?></div>
                
                <!-- Shipping Info -->
                <div class="order-shipping">
                    <h4>Shipping Info</h4>
                    <p><?= $_user->full_name ?? 'Recipient' ?></p>
                    <p><?= $order->address_line1 ?></p>
                    <p><?= $order->city ?>, <?= $order->state ?></p>
                    <p><?= $order->postal_code ?>, <?= $order->country ?></p>
                </div>

                <!-- Order Status & ETA -->
                <?php
                    $created_at = new DateTime($order->created_at);
                    $estimated = clone $created_at;
                    $estimated->modify('+7 days');
                ?>
                <div class="order-status">
                    <div class="status"><?= ucfirst($order->status) ?></div>
                    <div class="estimated">
                        ETA: <?= $estimated->format('M d, Y') ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../../_foot.php'; ?>

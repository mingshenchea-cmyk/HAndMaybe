<?php
require '../../_base.php';

auth('Member');

// Get all orders by the logged-in user, with address details
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
            SELECT oi.quantity, oi.total_price, 
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
                            <span>Total: RM<?= number_format($item->total_price, 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Shipping Info -->
                <div class="order-shipping">
                    <h4>Shipping Info</h4>
                    <p><?= $_user->full_name ?? 'Recipient' ?></p>
                    <p><?= $order->address_line1 ?></p>
                    <p><?= $order->city ?>, <?= $order->state ?></p>
                    <p><?= $order->postal_code ?>, <?= $order->country ?></p>
                </div>

                <!-- Order Status & ETA -->
                <div class="order-status">
                    <div class="status"><?= ucfirst($order->status) ?></div>
                    <div class="estimated">
                        ETA: <?= isset($order->estimated_arrival) ? date('M d, Y', strtotime($order->estimated_arrival)) : 'TBD' ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../../_foot.php'; ?>

<?php
require '../../_base.php';
// ----------------------------------------------------------------------------
auth('Admin');

// Handle POST request to update order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_stm = $_db->prepare('
        UPDATE `order`
        SET status = ?
        WHERE order_id = ?
    ');
    $update_stm->execute([$status, $order_id]);

    header('Location: order_maintainence.php');
    exit;
}

// Get all orders with user and address info
$stm = $_db->query('
    SELECT o.*, u.name AS user_name, a.address_line1, a.city, a.state, a.postal_code, a.country
    FROM `order` o
    JOIN user u ON o.user_id = u.user_id
    JOIN address a ON o.address_id = a.address_id
    ORDER BY o.created_at DESC
');
$orders = $stm->fetchAll();

// For item listing
$item_query = $_db->prepare('
    SELECT oi.quantity,
           pv.color, pv.size, pv.product_photo,
           p.name 
    FROM order_items oi
    JOIN product_variation pv ON oi.variation_id = pv.variation_id
    JOIN product p ON pv.product_id = p.product_id
    WHERE oi.order_id = ?
');

//-----------------------------------------------------------------------------
$_title = 'Admin - Order Maintenance';
include '../../_head.php';
?>
<link rel="stylesheet" href="/css/orderhistory.css">

<div class="order-history-container">
    <h1>All User Orders</h1>

    <?php if (empty($orders)): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <?php
            $item_query->execute([$order->order_id]);
            $items = $item_query->fetchAll();
            $created_at = new DateTime($order->created_at);
            $estimated = clone $created_at;
            $estimated->modify('+7 days');
            ?>
            <div class="order-card">
                <!-- Admin: Show user info -->
                <div class="admin-user-info">
                    User: <?= $order->user_name ?> (ID: <?= $order->user_id ?>)
                </div>

                <!-- Items -->
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

                <!-- Shipping -->
                <div class="order-shipping">
                    <h4>Shipping Info</h4>
                    <p><?= $order->address_line1 ?></p>
                    <p><?= $order->city ?>, <?= $order->state ?></p>
                    <p><?= $order->postal_code ?>, <?= $order->country ?></p>
                </div>

                <!-- Admin: Status form -->
                <div class="order-status">
                    <div class="status <?= $order->status === 'cancelled' ? 'cancelled' : '' ?>">
                        <?= ucfirst($order->status) ?>
                    </div>

                    <div class="estimated">
                        ETA: <?= $estimated->format('M d, Y') ?>
                    </div>

                    <?php if ($order->status !== 'cancelled'): ?>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?= $order->order_id ?>">
                            <div class="status-options">
                                <label>
                                    <input type="radio" name="status" value="shipped" <?= $order->status === 'shipped' ? 'checked' : '' ?>> Shipped
                                </label>
                                <label>
                                    <input type="radio" name="status" value="delivered" <?= $order->status === 'delivered' ? 'checked' : '' ?>> Delivered
                                </label>
                            </div>
                            <button type="submit" class="update-status-btn">Update Status</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../../_foot.php'; ?>

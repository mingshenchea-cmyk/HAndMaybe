<?php
require '../../../_base.php';
<<<<<<< Updated upstream
=======
// ----------------------------------------------------------------------------
>>>>>>> Stashed changes
auth('Admin');

//-----------------------------------------------------------------------------
// Handle status update
if (is_post() && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $check = $_db->prepare('SELECT status FROM `order` WHERE order_id = ?');
    $check->execute([$order_id]);
    $current = $check->fetch();

    if ($current && strtolower($current->status) !== 'cancelled') {
        $update_stm = $_db->prepare('UPDATE `order` SET status = ? WHERE order_id = ?');
        $update_stm->execute([$status, $order_id]);
    }

    redirect("order_maintenance.php");
}

//-----------------------------------------------------------------------------

$filter_status = isset($_GET['status']) ? strtolower($_GET['status']) : '';

// Build SQL based on filter
$sql = '
    SELECT o.*, u.name AS username, 
           a.address_line1, a.city, a.state, a.postal_code, a.country
    FROM `order` o
    JOIN user u ON o.user_id = u.user_id
    JOIN address a ON o.address_id = a.address_id
';

$params = [];
if ($filter_status === 'shipped' || $filter_status === 'delivered') {
    $sql .= ' WHERE LOWER(o.status) = ?';
    $params[] = $filter_status;
}
$sql .= ' ORDER BY o.created_at DESC';

$stm = $_db->prepare($sql);
$stm->execute($params);
$orders = $stm->fetchAll();

$item_query = $_db->prepare('
    SELECT oi.quantity, pv.color, pv.size, pv.product_photo, p.name
    FROM order_items oi
    JOIN product_variation pv ON oi.variation_id = pv.variation_id
    JOIN product p ON pv.product_id = p.product_id
    WHERE oi.order_id = ?
');

<<<<<<< Updated upstream
$_title = 'Admin Order Maintenance';
=======
//-----------------------------------------------------------------------------
$_title = 'Admin - Order Maintenance';
>>>>>>> Stashed changes
include '../../../_head.php';
?>
<link rel="stylesheet" href="/css/orderhistory.css">

<div class="order-history-container">
    <h1>Users Order</h1>

    <!-- Filter form -->
    <form method="GET" style="margin-bottom: 20px;">
        <label for="status">Filter by Status:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="shipped" <?= $filter_status === 'shipped' ? 'selected' : '' ?>>Shipped</option>
            <option value="delivered" <?= $filter_status === 'delivered' ? 'selected' : '' ?>>Delivered</option>
        </select>
    </form>

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

            $status = trim(strtolower($order->status));
            ?>
            <div class="order-card">
                <div style="width: 100%; margin-bottom: 10px;">
                    <strong>User ID:</strong> <?= $order->user_id ?> |
                    <strong>Username:</strong> <?= $order->username ?>
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

                <!-- Status -->
                <div class="order-status">
                    <div class="status <?= $status === 'cancelled' ? 'cancelled' : '' ?>">
                        <?= ucfirst($status) ?>
                    </div>

                    <?php if ($status !== 'cancelled'): ?>
                        <form method="POST">
                            <div class="status-label">Update Status:</div>
                            <input type="hidden" name="order_id" value="<?= $order->order_id ?>">

                            <label>
                                <input type="radio" name="status" value="shipped" <?= $status === 'shipped' ? 'checked' : '' ?>>
                                Shipped
                            </label><br>
                            <label>
                                <input type="radio" name="status" value="delivered" <?= $status === 'delivered' ? 'checked' : '' ?>>
                                Delivered
                            </label>

                            <button type="submit" class="update-btn">Update</button>
                        </form>
                        <div class="estimated">ETA: <?= $estimated->format('M d, Y') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../../../_foot.php'; ?>

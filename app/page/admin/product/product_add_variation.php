<?php
require '../../../_base.php';
//-----------------------------------------------------------------------------

// Get product and variation data
$_size = ['XS', 'S', 'M', 'L', 'XL'];
$_product = getAllProducts();
$new_product_id = null;

//-----------------------------------------------------------------------------
// Include the header
include '../../../_head.php';
?>

<link rel="stylesheet" href="/css/product.css">

<?php
// Check if the form is submitted to update
if (is_post() && isset($_POST['action']) && post('action') == 'add'): ?>
    <?php
    $new_product_name = post('product_name');
    $new_size = post('product_size');

    $new_color = post('product_color');

    $new_quantity = post('product_quantity');

    $photo_tmp_path = $_FILES['product_photo']['tmp_name'];
    $new_photo = basename($_FILES['product_photo']['name']);
    ?>

    <?php if ($new_photo == ''):
        $_err['product_photo'] = "Required";
    ?>
    <?php endif ?>

    <?php if ($new_product_name == ''):
        $_err['product_name'] = "Required";
    ?>
    <?php endif ?>

    <?php if ($new_color == ''):
        $_err['product_color'] = "Required";
    ?>
    <?php endif ?>

    <?php if ($new_quantity === ''):
        $_err['product_quantity'] = "Required";
    ?>
    <?php endif ?>

    <?php $new_color = ucfirst(strtolower($new_color)); ?>

    <?php
    if (!empty($photo_tmp_path) && $_FILES['product_photo']['error'] == UPLOAD_ERR_OK): ?>
        <?php move_uploaded_file($photo_tmp_path, to: "../../../images/".$new_photo); ?>
    <?php endif ?>

    <?php
    //Find product_id
    foreach ($_product as $p): ?>
        <?php if ($p->name == $new_product_name): ?>
            <?php $new_product_id = $p->product_id; ?>
        <?php endif ?>
    <?php endforeach ?>

    <?php
    // CHECK if variation already exists
    $check_stmt = $_db->prepare("SELECT COUNT(*) FROM product_variation WHERE product_id = ? AND size = ? AND color = ?");
    $check_stmt->execute([$new_product_id, $new_size, $new_color]);
    $count = $check_stmt->fetchColumn(); ?>

    <?php if (!$_err): ?>
        <?php
        if ($count == 0): ?>
            <?php insertVariation($new_product_id, $new_size, $new_color, $new_quantity, $new_photo); ?>
            <?php temp('info', 'New Product Variation Added!'); ?>
            <?php redirect("/page/admin/product/product_maintenance.php"); ?>
        <?php endif ?>
    <?php endif ?>
<?php endif ?>

<div class="container">
    <div class='product_box'>
        <div class="add_item">
            <img class='add_icon' src='/images/add_circle.png' alt='add_circle'>
        </div>
        <div class='detail'>

            <!-- Display input field for add -->
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">

                <div class="category_div">
                    <p class='color'>Photo: </p>
                    <?= html_file('product_photo', 'image/*') ?>
                    <?= err('product_photo') ?>
                </div>

                <div class="category_div">
                    <p class='color'>Name: </p>
                    <select name='product_name'>
                        <?php foreach ($_product as $p): ?>
                            <option value="<?= $p->name ?>"><?= $p->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="category_div">
                    <p class='color'>Size: </p>
                    <select name='product_size'>
                        <?php foreach ($_size as $s): ?>
                            <option value=<?= $s ?>><?= $s ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="category_div">
                    <p class='color'>Color: </p>
                    <input class="add_variation" type='text' name='product_color'>
                    <?= err('product_color') ?>
                </div>
                <div class="name_div">
                    <input class="add_variation" type='number' name='product_quantity' placeholder='Product Quantity' step='1' min='0'>
                    <?= err('product_quantity') ?>
                </div>

                <button type="submit" class="save_button">
                    <img class="delete_icon" src="/images/save.png">
                    <p class="add">Add</p>
                </button>
            </form>
        </div>
    </div>

    </html>

    <?php
    // Include the footer
    include '../../../_foot.php';
    ?>
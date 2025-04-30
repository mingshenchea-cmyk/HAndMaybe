<?php
require '../../../_base.php';
//-----------------------------------------------------------------------------

// Get data
$_category = $_db->query('SELECT DISTINCT category FROM product')->fetchAll();

//-----------------------------------------------------------------------------
// Include the header
include '../../../_head.php';
?>

<link rel="stylesheet" href="/css/product.css">

<?php
// Check if the form is submitted to update
if (is_post() && isset($_POST['action']) && post('action') == 'add'): ?>
    <?php
    $new_name = post('product_name');
    $new_name = ucwords(strtolower($new_name));
    $new_price = post('product_price');
    $new_description = post('product_description');
    $new_category = post('product_category');

    // Check if same name and same category already exist
    $check_stmt = $_db->prepare("SELECT COUNT(*) FROM product WHERE name = ? AND category = ?");
    $check_stmt->execute([$new_name, $new_category]);
    $count = $check_stmt->fetchColumn();
    ?>

    <?php if ($new_name == ''):
        $_err['product_name'] = "Required";
    ?>
    <?php endif ?>

    <?php if ($new_price == ''):
        $_err['product_price'] = "Required";
    ?>
    <?php endif ?>

    <?php if ($new_description == ''):
        $_err['product_description'] = "Required";
    ?>
    <?php endif ?>

    <?php
    $new_price = number_format((float) $new_price, 2, '.', '');
    // Capitalize the first letter of the first word
    $new_description = ucfirst(strtolower(trim($new_description)));
    ?>

    <?php
    // Ensure the sentence ends with a period
    if (substr($new_description, -1) !== '.'): ?>
        <?php $new_description .= '.'; ?>
    <?php endif ?>

    <?php if (!$_err): ?>
        <?php if ($count == 0): ?>
            <?php
            $stmt = $_db->prepare("INSERT INTO product (name, category, description, price, created_at) VALUES (?,?,?,?,NOW())");
            $stmt->execute([$new_name, $new_category, $new_description, $new_price]);

            redirect("/page/admin/prodcut/product_maintenance.php");
        ?>
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

                <div class="name_div">
                    <input type='text' name='product_name' placeholder='Product Name'>
                    <?= err('product_name') ?>
                    <input type='number' name='product_price' placeholder='Product Price' step='0.1' min='0'>
                    <?= err('product_price') ?>
                    <textarea name='product_description' placeholder='Product Description' cols='90'
                        rows='5'></textarea>
                    <?= err('product_description') ?>
                </div>
                <div class="category_div">
                    <p class='color'>Category: </p>
                    <select name='product_category'>

                        <?php foreach ($_category as $cat): ?>
                            <option value=<?= $cat->category ?>><?= $cat->category ?></option>
                        <?php endforeach ?>

                    </select>
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
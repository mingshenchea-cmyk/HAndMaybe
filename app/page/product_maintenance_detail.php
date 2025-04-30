<?php
require '../_base.php';
//-----------------------------------------------------------------------------

// Get product and variation data
$_product = getAllProducts();
$_product_variation = getAllProductVariations();

$variation_id = get('variation_id');
$color = get('color');
$size = null;
$_category = $_db->query('SELECT DISTINCT category FROM product')->fetchAll();

//-----------------------------------------------------------------------------
// Include the header
include '../_head.php';
?>

<link rel="stylesheet" href="/css/product.css">

<div class="container">
    <?php
    foreach ($_product_variation as $variation):
        if ($variation_id == $variation->variation_id): ?>
            <div class='product_box'>
                <img class='product_image' src='<?= $variation->product_photo ?>' alt='<?= $variation_id ?>'>
                <div class='detail'>

                    <?php foreach ($_product as $product):
                        if ($variation->product_id == $product->product_id): ?>
                            <?php
                            $product_id = $product->product_id;  // Get product ID
                            $product_name = $product->name;
                            ?>

                            <?php
                            // Check if the form is submitted to update
                            if (is_post() && isset($_POST['action']) && post('action') == 'save'):
                                $new_name = req('product_name');
                                $new_name = ucwords(strtolower($new_name));

                                $new_price = req('product_price');
                                $new_price = number_format((float) $new_price, 2, '.', '');

                                $new_description = req('product_description');
                                // Capitalize the first letter of the first word
                                $new_description = ucfirst(strtolower(trim($new_description)));
                                ?>
                                <?php
                                // Ensure the sentence ends with a period
                                if (substr($new_description, -1) !== '.'):
                                    $new_description .= '.'; ?>
                                <?php endif ?>

                                <?php
                                $new_category = req('product_category');
                                $new_color = req('product_color');

                                $photo_tmp_path = $_FILES['product_photo']['tmp_name'];
                                $photo_name = basename($_FILES['product_photo']['name']);
                                $photo_destination = '../images/' . $photo_name;
                                ?>

                                <?php if (isset($photo_tmp_path) && $_FILES['product_photo']['error'] == UPLOAD_ERR_OK): ?>
                                    <?php
                                    // Move uploaded file to the uploads folder
                                    if (move_uploaded_file($photo_tmp_path, $photo_destination)):
                                        // Save the new photo path to the database, as well as other details
                                        updateProduct($product_id, $new_name, $new_price, $new_description, $new_category);
                                        updateProductVariation($product_id, $variation->color, $new_color, $photo_destination);
                                        ?>
                                    <?php else:
                                        echo "Error: Could not upload photo."; ?>
                                    <?php endif ?>
                                <?php else:
                                    // If no new photo, update other details
                                    updateProduct($product_id, $new_name, $new_price, $new_description, $new_category);
                                    updateProductVariation($product_id, $variation->color, $new_color, $variation->product_photo);
                                    ?>
                                <?php endif ?>
                                <?php
                                // Redirect back to the same page
                                redirect();
                                ?>
                            <?php endif ?>

                            <?php if (is_post() && isset($_POST['action']) && post('action') == 'delete'):
                                deleteProductVariation($product_id, $variation->color);

                                redirect('Location: ../page/product_maintenance.php');
                                ?>
                            <?php endif ?>

                            <?php
                            // Display current product and edit button
                            if (!is_post()): ?>
                                <p class='detail_name'><?= $product_name ?></p>
                                <p class='detail_price'>RM<?= number_format($product->price, 2) ?></p>
                                <p class='description'><?= $product->description ?></p>
                                <p class='color'>Category:<?= $product->category ?></p>
                                <p class='color'>Color:<?= $variation->color ?></p>

                                <form action='' method='POST'>
                                    <button type='submit' class='add_button'>
                                        <img class='button_icon' src='/images/edit.png'>
                                        <p class='add'>Edit</p>
                                    </button>
                                </form>

                                <form action='' method='POST'>
                                    <input type='hidden' name='action' value='delete'>
                                    <button type='submit' class='delete_button'>
                                        <img class='delete_icon' src='/images/delete.png'>
                                        <p class='add'>Delete</p>
                                    </button>
                                </form>
                            <?php else: ?>
                                <!-- Display input field for updating -->
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="save">

                                    <div class="category_div">
                                        <p class='color'>Photo: </p>
                                        <input type='file' name='product_photo'>
                                    </div>
                                    <div class="name_div">
                                        <input type='text' name='product_name' value='<?= $product_name ?>'>
                                        <input type='number' name='product_price' placeholder='Product Price' step='0.1' min='0'
                                            value='<?= $product->price ?>'>
                                        <textarea name='product_description' cols='90'
                                            rows='5'><?= htmlspecialchars($product->description) ?></textarea>
                                    </div>
                                    <div class="category_div">
                                        <p class='color'>Category: </p>
                                        <select name='product_category'>
                                            <?php
                                            foreach ($_category as $cat): ?>
                                                <option value='<?= $product->category ?>'><?= $cat->category ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="category_div">
                                        <p class='color'>Color: </p>
                                        <input type='text' name='product_color' value='<?= $variation->color ?>'>
                                    </div>

                                    <button type="submit" class="save_button">
                                        <img class="delete_icon" src="/images/save.png">
                                        <p class="add">Save</p>
                                    </button>
                                </form>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    </html>

    <?php
    // Include the footer
    include '../_foot.php';
    ?>
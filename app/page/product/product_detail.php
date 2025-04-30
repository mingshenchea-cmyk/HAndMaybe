<?php
require '../../_base.php';
//-----------------------------------------------------------------------------

$_product = getAllProducts();
$_product_variation = getAllProductVariations();
$_category = getAllCategory();

$variation_id = get('variation_id');
$color = get('color');
$category = null;
$category_num;
$size = null;

//-----------------------------------------------------------------------------
// Include the header
include '../../_head.php';
?>

<link rel="stylesheet" href="/css/product.css">

<?php
// Handle the form submission and call the add_to_cart function
if (is_post()): ?>
    <?php $quantity = 1; // Default to 1 if not provided ?>
    <?php // Call the add_to_cart function
        add_to_cart($variation_id, $quantity, $category_num);
        update_cart($variation_id, $quantity); ?>
<?php endif ?>

<div class="container">
    <?php foreach ($_product_variation as $variation): ?>
        <?php if ($variation_id == $variation->variation_id): ?>
            <div class='product_box'>
                <img class='product_image' src="/images/<?= $variation->product_photo ?>" alt='<?= $variation_id ?>'>
                <div class='detail'>
                    <?php foreach ($_product as $product): ?>
                        <?php if ($variation->product_id == $product->product_id): ?>
                            <p class='detail_name'><?= $product->name ?></p>
                            <p class='detail_price'>RM<?= number_format($product->price, 2) ?></p>
                            <p class='description'><?= $product->description ?></p>
                            <?php $color = $variation->color; ?>
                            <?php foreach ($_category as $categorys): ?>
                                <?php if ($categorys->category_id == $product->category_id): ?>
                                    <?php $category = $categorys->category ?>
                                    <?php $category_num = $categorys->category_id ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endforeach ?>
                    <p class='color'>Color: <?= $color ?></p>
                    <p class='color'>Category: <?= $category ?></p>
                    <p class='select_size'>Select size</p>

                    <?php $size = $variation->size;
                    $product_id = $variation->product_id ?>
                    <table class='size'>
                        <tr>

                            <?php $sizes = ['XS', 'S', 'M', 'L', 'XL']; ?>
                            <?php $target_variation_id = null; ?>
                            <?php foreach ($sizes as $s): ?>
                                <?php foreach ($_product_variation as $v): ?>
                                    <?php if ($v->product_id == $product_id && $v->color == $color && $v->size == $s): ?>
                                        <?php $target_variation_id = $v->variation_id; ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <?php
                                // Only if found
                                if ($target_variation_id !== null): ?>
                                    <?php $selected = ($s == $size) ? "class='selected'" : ""; ?>
                                    <td <?= $selected ?>><a href='?variation_id=<?= $target_variation_id ?>&color=<?= $color ?>'
                                            class='size_selected'><?= $s ?></a></td>
                                <?php endif ?>
                            <?php endforeach ?>
                        </tr>
                    </table>

                    <form action='' method='POST'>
                        <input type='hidden' name='variation_id' value='<?= $variation->variation_id ?>'>
                        <input type='hidden' name='quantity' value='1'>
                        <button type='submit' class='add_button'>
                            <img class='button_icon' src='/images/shopping_bag.png'>
                            <p class='add'>Add</p>
                        </button>
                    </form>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>

</html>

<?php
// Include the footer
include '../../_foot.php';
?>
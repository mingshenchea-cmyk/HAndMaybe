<?php
require '../../../_base.php';
//-----------------------------------------------------------------------------

$_product = getAllProducts();
$_product_variation = getAllProductVariations();

$query = get('query'); 
$color_shown = [];
$k=0;

//-----------------------------------------------------------------------------
// Include the header
include '../../../_head.php';
?>

<link rel="stylesheet" href="/css/product.css">

<div class="container">
    <?php
    foreach ($_product as $product) :
        foreach ($_product_variation as $variation) :
            // Check if searching or category filtering
            $shouldDisplay = false;
            ?>

            <?php if (!empty($query)): ?>
                <?php
                // If there is a search keyword
                if (stripos($product->name, $query) !== false): ?>
                    <?php $shouldDisplay = true; ?>
                <?php endif ?>
            <?php else: ?>
                <?php
                // If no search query, display all items
                $shouldDisplay = true;
                ?>
            <?php endif ?>

            <?php
            // If product should be displayed based on search or category
            if ($shouldDisplay):
                if ($product->product_id == $variation->product_id):
                    if ($variation->color !== $color_shown): ?>
                    <?php
                        $color_shown = $variation->color;
                    ?>
                        <?php if($k == 0): ?>
                            <div class='product'>
                            <a href='/page/admin/product/product_add.php' class='product_link'>
                            <div class="add_item">
                            <img class='add_icon' src='/images/add_circle.png' alt='add_circle'>
                            </div>
                            <p class='name'>Add New Product</p>
                            </div>

                            <div class='product'>
                            <a href='/page/admin/product/product_add_variation.php' class='product_link'>
                            <div class="add_item">
                            <img class='add_icon' src='/images/add_circle.png' alt='add_circle'>
                            </div>
                            <p class='name'>Add New Variation</p>
                            </div>
                            <?php $k = 1; ?>
                        <?php endif ?>

                        <div class='product'>
                        <a href='/page/admin/product/product_maintenance_detail.php?variation_id=<?=$variation->variation_id?>&color=<?=$color_shown?>' class='product_link'>
                        <img class='product_photo' src='/images/<?=$variation->product_photo?>' alt='<?=$product->name?>'>
                        <p class='name'><?= $product->name?></p>
                        <p class='price'>RM<?=number_format($product->price, 2)?></p>
                        </a>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
        <?php endforeach ?>
    <?php endforeach ?>
</div>

</html>

<?php
// Include the footer
include '../../../_foot.php';
?>
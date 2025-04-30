<?php
require '../../_base.php';
//-----------------------------------------------------------------------------

$_product = getAllProducts();
$_product_variation = getAllProductVariations();
$_category = getAllCategory();

$category = get('category');
$query = get('query');
$color_shown = [];

//-----------------------------------------------------------------------------
// Include the header
include '../../_head.php';
?>

<link rel="stylesheet" href="/css/product.css">

<div class="container">
    <?php foreach ($_product as $product):
        foreach ($_product_variation as $variation): ?>
            <!-- Check if searching or category filtering -->
            <?php $shouldDisplay = false; ?>

            <?php if (!empty($query)): ?>
                <?php
                // If there is a search keyword
                if (stripos($product->name, $query) !== false) {
                    $shouldDisplay = true;
                }
                ?>
            <?php elseif (!empty($category)): ?>
                <?php
                // If there is a category
                if ($product->category_id == $category) {
                    $shouldDisplay = true;
                }
                ?>
            <?php else: ?>
                <?php $shouldDisplay = true; ?>                
            <?php endif ?>

            <!-- If product should be displayed based on search or category -->
            <?php if ($shouldDisplay): ?>
                <?php if ($product->product_id == $variation->product_id): ?>
                    <?php if ($variation->color !== $color_shown): ?>
                        <?php $color_shown = $variation->color; ?>
                        <div class='product'>
                            <a href="/page/product/product_detail.php?variation_id=<?= $variation->variation_id ?>&color=<?= $color_shown ?>"
                                class='product_link'>
                                <img class="product_photo" src="/images/<?= $variation->product_photo ?>" alt="<?= $product->name ?>">
                                <p class="name"><?= $product->name ?></p>
                                <p class="price">RM<?= number_format($product->price, 2) ?></p>
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
include '../../_foot.php';
?>
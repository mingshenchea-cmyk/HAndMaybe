<?php
require '../_base.php';
//-----------------------------------------------------------------------------

$_product = $_db->query('SELECT * FROM product')->fetchAll();
$_product_variation = $_db->query('SELECT * FROM product_variation')->fetchAll();

$category = get('category');
$color_shown = [];

//-----------------------------------------------------------------------------
// Include the header
include '../_head.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H&Maybe | Women's, Men's Fashion | H&Maybe MY</title>
    <link rel="icon" href="/images/HAndMaybe.png">
    <link rel="stylesheet" href="/css/handmaybe.css">
    <link rel="stylesheet" href="/css/product.css">
    <script src="/js/handmaybe.js"></script>
</head>

<div class="container">
    <?php
    foreach ($_product as $product) {
        foreach ($_product_variation as $variation) {
            if ($product->category == $category) {
                if ($product->product_id == $variation->product_id) {
                    if ($variation->color !== $color_shown) {
                        echo "<div class='product'>";
                        echo "<a href='../page/product_detail.php?variation_id=" . $variation->variation_id . "' class='product_link'>";
                        echo "<img class= 'product_photo' src='" . $variation->product_photo . "' alt='" .$product->name . "'>";
                        echo "<p class='name'>" . $product->name . "</p>";
                        echo "<p class='price'>RM" . number_format($product->price, 2) . "</p>";
                        echo "</div>";
                        $color_shown = $variation->color;
                    }
                }
            }
        }
    }
    ?>
</div>

</html>

<?php
// Include the footer
include '../_foot.php';
?>
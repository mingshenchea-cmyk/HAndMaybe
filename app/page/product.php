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

<div class="container">
    <?php
    foreach ($_product as $product) {
        foreach ($_product_variation as $variation) {
            if ($product->category == $category) {
                if ($product->product_id == $variation->product_id) {
                    if ($variation->color !== $color_shown) {
                        $color_shown = $variation->color;
                        echo "<div class='product'>";
                        echo "<a href='../page/product_detail.php?variation_id=" . $variation->variation_id . "&color= ".$color_shown."' class='product_link'>";
                        echo "<img class= 'product_photo' src='" . $variation->product_photo . "' alt='" .$product->name . "'>";
                        echo "<p class='name'>" . $product->name . "</p>";
                        echo "<p class='price'>RM" . number_format($product->price, 2) . "</p>";
                        echo "</div>";                        
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
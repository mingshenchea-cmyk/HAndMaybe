<?php
require '../_base.php';
//-----------------------------------------------------------------------------

$_product = getAllProducts();
$_product_variation = getAllProductVariations();

$category = get('category');
$query = get('query'); 
$color_shown = [];

//-----------------------------------------------------------------------------
// Include the header
include '../_head.php';
?>

<div class="container">
    <?php
    foreach ($_product as $product) {
        foreach ($_product_variation as $variation) {
            // Check if searching or category filtering
            $shouldDisplay = false;

            if (!empty($query)) {
                // If there is a search keyword
                if (stripos($product->name, $query) !== false) {
                    $shouldDisplay = true;
                }
            } elseif (!empty($category)) {
                // If there is a category
                if ($product->category == $category) {
                    $shouldDisplay = true;
                }
            }

            // If product should be displayed based on search or category
            if ($shouldDisplay) {
                if ($product->product_id == $variation->product_id) {
                    if ($variation->color !== $color_shown) {
                        $color_shown = $variation->color;
                        echo "<div class='product'>";
                        echo "<a href='../page/product_detail.php?variation_id=" . $variation->variation_id . "&color=" . $color_shown . "' class='product_link'>";
                        echo "<img class='product_photo' src='" . $variation->product_photo . "' alt='" . $product->name . "'>";
                        echo "<p class='name'>" . $product->name . "</p>";
                        echo "<p class='price'>RM" . number_format($product->price, 2) . "</p>";
                        echo "</a>";
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
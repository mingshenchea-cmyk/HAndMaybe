<?php
require '../_base.php';
//-----------------------------------------------------------------------------

$_product = getAllProducts();
$_product_variation = getAllProductVariations();

$query = get('query'); 
$color_shown = [];
$k=0;

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
            } else {
                // If no search query, display all items
                $shouldDisplay = true;
            }

            // If product should be displayed based on search or category
            if ($shouldDisplay) {
                if ($product->product_id == $variation->product_id) {
                    if ($variation->color !== $color_shown) {
                        $color_shown = $variation->color;
                        
                        if($k == 0){
                            echo "<div class='product'>";
                            echo "<a href='../page/product_add.php' class='product_link'>";
                            echo '<div class="add_item">';
                            echo "<img class='add_icon' src='../images/add_circle.png' alt='add_circle'>";
                            echo '</div>';
                            echo "<p class='name'>Add New Product</p>";
                            echo '</div>';

                            echo "<div class='product'>";
                            echo "<a href='../page/product_add_variation.php' class='product_link'>";
                            echo '<div class="add_item">';
                            echo "<img class='add_icon' src='../images/add_circle.png' alt='add_circle'>";
                            echo '</div>';
                            echo "<p class='name'>Add New Variation</p>";
                            echo '</div>';
                            $k = 1;
                        }
                        echo "<div class='product'>";
                        echo "<a href='../page/product_maintenance_detail.php?variation_id=" . $variation->variation_id . "&color=" . $color_shown . "' class='product_link'>";
                        echo "<img class='product_photo' src='" . $variation->product_photo . "' alt='" . $product->name . "'>";
                        echo "<p class='name'>" . $product->name . "</p>";
                        echo "<p class='price'>RM" . number_format($product->price, 2) . "</p>";
                        echo '';
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
<?php
require '../_base.php';

// ----------------------------------------------------------------------------
// Handle Add to Cart
// ----------------------------------------------------------------------------

if (is_post()) {
    $variation_id = post('variation_id');
    $quantity = 1; // Fixed quantity (no quantity selector yet)

    if ($variation_id) {
        update_cart($variation_id, $quantity); // Pass variation_id directly
    }
    redirect();
}

// ----------------------------------------------------------------------------
// Display Product Details 
// ----------------------------------------------------------------------------

$_product = getAllProducts();
$_product_variation = getAllProductVariations();

$variation_id = get('variation_id');
$color = get('color');
$size = null;

include '../_head.php';
?>

<div class="container">
    <?php
    foreach ($_product_variation as $variation) {
        if ($variation_id == $variation->variation_id) {
            echo "<div class='product_box'>";
            echo "<img class='product_image' src='" . htmlspecialchars($variation->product_photo) . "' alt='" . htmlspecialchars($variation_id) . "'>";
            echo "<div class='detail'>";
            
            foreach ($_product as $product) {
                if ($variation->product_id == $product->product_id) {
                    echo "<p class='detail_name'>" . htmlspecialchars($product->name) . "</p>";
                    echo "<p class='detail_price'>RM" . number_format($product->price, 2) . "</p>";
                    echo "<p class='description'>" . htmlspecialchars($product->description) . "</p>";
                    $color = $variation->color;
                    break;
                }
            }

            echo "<p class='color'>Color: " . htmlspecialchars($color) . "</p>";
            echo "<p class='select_size'>Select size</p>";

            $size = $variation->size;
            $product_id = $variation->product_id;
            echo "<table class='size'>
            <tr>";

            $sizes = ['XS', 'S', 'M', 'L', 'XL'];
            $target_variation_id = null;
            foreach ($sizes as $s) {
                foreach ($_product_variation as $v) {
                    if ($v->product_id == $product_id && $v->color == $color && $v->size == $s) {
                        $target_variation_id = $v->variation_id;
                        break;
                    }
                }
                // Only if found
                if ($target_variation_id !== null) {
                    $selected = ($s == $size) ? "class='selected'" : "";
                    echo "<td $selected><a href='?variation_id=$target_variation_id&color=$color' class='size_selected'>$s</a></td>";
                }  
            }
            echo "</tr>
            </table>";

            // Handle the form submission and call the add_to_cart function
            if (is_post() && isset($_POST['variation_id'])) {
                // Extract form data
                $variation_id = post('variation_id');
                $quantity = post('quantity', 1); // Default to 1 if not provided
                // Call the add_to_cart function
                add_to_cart($variation_id, $quantity);
                exit(); // Prevent further code execution after adding to cart
            }

            echo 
            "<form action='' method='POST'>
                <input type='hidden' name='variation_id' value='$variation->variation_id'>
                <input type='hidden' name='quantity' value='1'>
                <button type='submit' class='add_button'>
                    <img class='button_icon' src='/images/shopping_bag.png'>
                    <p class='add'>Add</p>
                </button>
            </form>";            
            echo "</div>";
            echo "</div>";
            break;
        }
    }
    ?>
</div>

<?php
include '../_foot.php';
?>

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

$_product = $_db->query('SELECT * FROM product')->fetchAll();
$_product_variation = $_db->query('SELECT * FROM product_variation')->fetchAll();

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
            echo "<table class='size'>
                <tr>
                    <td>XS</td>
                    <td>S</td>
                    <td>M</td>
                    <td>L</td>
                    <td>XL</td>
                </tr>
                </table>";
            
            echo "<form method='post'>";
            echo "<input type='hidden' name='variation_id' value='" . htmlspecialchars($variation->variation_id) . "'>";
            echo "<input type='hidden' name='quantity' value='1'>"; // Always 1
            echo "<input type='hidden' name='size' value=''>"; 
            echo "<button type='submit' class='add_button'>";
            echo "<img class='button_icon' src='/images/shopping_bag.png'>";
            echo "<span class='add'>Add to Cart</span>";
            echo "</button>";
            echo "</form>";

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

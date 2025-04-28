<?php
require '../_base.php';

// ----------------------------------------------------------------------------
// Handle Add to Cart
// ----------------------------------------------------------------------------

if (is_post()) {
    $variation_id = post('variation_id');
    $quantity = 1; // Fixed quantity since we're not including quantity selector
    $size = post('size');
    
    // Get product ID from variation to work with your existing cart system
    $stm = $_db->prepare('SELECT product_id FROM product_variation WHERE variation_id = ?');
    $stm->execute([$variation_id]);
    $product_id = $stm->fetchColumn();
    
    if ($product_id) {
        update_cart($product_id, $quantity); // Uses your existing update_cart function
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
            echo "<img class='product_image' src='" . $variation->product_photo . "' alt='" . $variation_id . "'>";
            echo "<div class='detail'>";
            foreach ($_product as $product) {
                if ($variation->product_id == $product->product_id) {
                    echo "<p class='detail_name'>" . $product->name . "</p>";
                    echo "<p class='detail_price'>RM" . number_format($product->price, 2) . "</p>";
                    echo "<p class='description'>".$product->description."</p>";
                    $color = $variation->color;
                    break;
                }
            }
            echo "<p class='color'>Color: ".$color."</p>";
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
            echo "<input type='hidden' name='variation_id' value='$variation->variation_id'>";
            echo "<input type='hidden' name='quantity' value='1'>"; // Fixed quantity of 1
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
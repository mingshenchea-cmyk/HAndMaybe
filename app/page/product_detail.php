<?php
require '../_base.php';
//-----------------------------------------------------------------------------

$_product = $_db->query('SELECT * FROM product')->fetchAll();
$_product_variation = $_db->query('SELECT * FROM product_variation')->fetchAll();

$variation_id = get('variation_id');
$color = get('color');

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
    foreach ($_product_variation as $variation) {
        if ($variation_id == $variation->variation_id) {
            echo "<div class='product_box'>";
            echo "<img class= 'product_image' src='" . $variation->product_photo . "' alt='" . $variation_id . "'>";
            echo "<div class='detail'>";
            foreach ($_product as $product) {
                if ($variation->product_id == $product->product_id) {
                    echo "<p class='detail_name'>" . $product->name . "</p>";
                    echo "<p class='detail_price'>RM" . number_format($product->price, 2) . "</p>";
                    echo "<p class='description'>".$product->description."</p>";
                    // echo "<p class='color'>Color: ".$variation->color."</p>";
                    $color = $variation->color;
                    break;
                }
            }
            echo "<p class='color'>Color: ".$color."</p>";
            echo "";
            echo "<p class='select_size'>Select size</p>";
            // echo "<form action='' method='GET'>
            echo "<table class='size'>
            <tr>
            <td onclick=\"selectSize('XS')\">XS</td>
            <td>S</td>
            <td>M</td>
            <td>L</td>
            <td>XL</td>
            </tr>
            </table>";
            echo "<form>
            <button class='add_button'>
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

</html>

<?php
// Include the footer
include '../_foot.php';
?>
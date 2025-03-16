<?php
require '../_base.php';
//-----------------------------------------------------------------------------

$_product = $_db->query('SELECT * FROM product')->fetchAll();
$_product_variation = $_db->query('SELECT * FROM product_variation')->fetchAll();

$variation_id = get('variation_id');

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
            // echo "<div class=''>";
            echo "<img class= 'product_image' src='" . $variation->product_photo . "' alt='" . $variation_id . "'>";
            echo "<div class='detail'>";
            foreach ($_product as $product) {
                if ($variation->product_id == $product->product_id) {
                    echo "<p class='detail_name'>" . $product->name . "</p>";
                    echo "<p class='detail_price'>" . $product->price . "</p>";
                    echo "<p class='description'>".$product->description."</p>";
                    echo "<p class='color'>Color: ".$variation->color."</p>";
                    break;
                }
            }
            echo "<p>Select size</p>";
            echo "<form><button>Add</button></form>";            
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
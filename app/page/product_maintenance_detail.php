<?php
require '../_base.php';
//-----------------------------------------------------------------------------

// Get product and variation data
$_product = getAllProducts();
$_product_variation = getAllProductVariations();

$variation_id = get('variation_id');
$color = get('color');
$size = null;
$_category = $_db->query('SELECT DISTINCT category FROM product')->fetchAll();

//-----------------------------------------------------------------------------
// Include the header
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
                    $product_id = $product->product_id;  // Get product ID
                    $product_name = $product->name; 

                    // Check if the form is submitted to update
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
                        $new_name = $_POST['product_name'];
                        $new_name = ucwords(strtolower($new_name));
    
                        $new_price = $_POST['product_price'];
                        $new_price = number_format((float)$new_price, 2, '.', '');

                        $new_description = $_POST['product_description'];
                        // Capitalize the first letter of the first word
                        $new_description = ucfirst(strtolower(trim($new_description)));

                        // Ensure the sentence ends with a period
                        if (substr($new_description, -1) !== '.') {
                            $new_description .= '.';
                        }

                        $new_category = $_POST['product_category'];
                        $new_color = $_POST['product_color'];

                        $photo_tmp_path = $_FILES['product_photo']['tmp_name'];
                        $photo_name = basename($_FILES['product_photo']['name']);
                        $photo_destination = '../images/' . $photo_name;

                        if (isset($photo_tmp_path) && $_FILES['product_photo']['error'] == UPLOAD_ERR_OK) {
                            // Move uploaded file to the uploads folder
                            if (move_uploaded_file($photo_tmp_path, $photo_destination)) {
                                // Save the new photo path to the database, as well as other details
                                updateProduct($product_id, $new_name, $new_price, $new_description, $new_category);
                                updateProductVariation($product_id, $variation->color, $new_color, $photo_destination);
                            } else {
                                echo "Error: Could not upload photo.";
                            }
                        } else {
                            // If no new photo, update other details
                            updateProduct($product_id, $new_name, $new_price, $new_description, $new_category);
                            updateProductVariation($product_id, $variation->color, $new_color, $variation->product_photo);
                        }
                        // Redirect back to the same page or show a success message
                        header('Location: ' . $_SERVER['REQUEST_URI']);
                        exit;
                    }

                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete'){
                        deleteProductVariation($product_id, $variation->color);

                        header('Location: ../page/product_maintenance.php');
                        exit;
                    }

                    // Display current product and edit button
                    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                        echo "<p class='detail_name'>" . $product_name. "</p>";
                        echo "<p class='detail_price'>RM" . number_format($product->price, 2) . "</p>";
                        echo "<p class='description'>" . $product->description . "</p>";
                        echo "<p class='color'>Category: " . $product->category . "</p>";
                        echo "<p class='color'>Color: " . $variation->color . "</p>";

                        echo "<form action='' method='POST'>
                            <button type='submit' class='add_button'>
                                <img class='button_icon' src='/images/edit.png'>
                                <p class='add'>Edit</p>
                            </button>
                            </form>";

                        echo "<form action='' method='POST'>";
                        echo "<input type='hidden' name='action' value='delete'>
                            <button type='submit' class='delete_button'>
                                <img class='delete_icon' src='/images/delete.png'>
                                <p class='add'>Delete</p>
                            </button>
                          </form>";
                    } else {
                        // Display input field for updating
                        echo '<form action="" method="POST" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="action" value="save">';

                        echo '<div class="category_div">';
                        echo "<p class='color'>Photo: </p>";
                        echo "<input type='file' name='product_photo'>";
                        echo '</div>';
                        echo '<div class="name_div">';
                        echo "<input type='text' name='product_name' value='" . $product_name . "'>";
                        echo "<input type='number' name='product_price' placeholder='Product Price' step='0.1' min='0' value='" . $product->price . "'>";
                        echo "<textarea name='product_description' cols='90' rows='5'>" . $product->description . "</textarea>";
                        echo '</div>';
                        echo '<div class="category_div">';
                        echo "<p class='color'>Category: </p>";
                        echo "<select name='product_category'>";
                        foreach ($_category as $cat) {
                            echo "<option value='$product->category'>" . $cat->category . "</option>";
                        }
                        echo "</select>";
                        echo '</div>';
                        echo '<div class="category_div">';
                        echo "<p class='color'>Color: </p>";
                        echo "<input type='text' name='product_color' value='" . $variation->color . "'>";
                        echo '</div>';
                        
                        echo '<button type="submit" class="save_button">
                                <img class="delete_icon" src="/images/save.png">
                                    <p class="add">Save</p></button>';
                        echo '</form>';
                    }
                    break;
                }
            }
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

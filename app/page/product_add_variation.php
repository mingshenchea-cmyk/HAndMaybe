<?php
require '../_base.php';
//-----------------------------------------------------------------------------

// Get product and variation data
$_size = ['XS', 'S', 'M', 'L', 'XL'];
$_product = getAllProducts();

//-----------------------------------------------------------------------------
// Include the header
include '../_head.php';
?>

<div class="container">
    <?php
    echo "<div class='product_box'>";
    echo '<div class="add_item">';
    echo "<img class='add_icon' src='../images/add_circle.png' alt='add_circle'>";
    echo '</div>';
    echo "<div class='detail'>";

    // Check if the form is submitted to update
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
        $new_product_name = $_POST['product_name'];
        $new_size = $_POST['product_size'];

        $new_color = $_POST['product_color'];
        $new_color = ucfirst(strtolower($new_color));

        $new_quantity = $_POST['product_quantity'];

        $photo_tmp_path = $_FILES['product_photo']['tmp_name'];
        $photo_name = basename($_FILES['product_photo']['name']);
        $new_photo = '../images/' . $photo_name;

        //Find product_id
        foreach ($_product as $p) {
            if ($p->name == $new_product_name) {
                $new_product_id = $p->product_id;
            }
        }

        // CHECK if variation already exists
        $check_stmt = $_db->prepare("SELECT COUNT(*) FROM product_variation WHERE product_id = ? AND size = ? AND color = ? AND product_photo = ?");
        $check_stmt->execute([$new_product_id, $new_size, $new_color, $new_photo]);
        $count = $check_stmt->fetchColumn();
    
        //if (isset($photo_tmp_path) && $_FILES['product_photo']['error'] == UPLOAD_ERR_OK) {
        if ($count == 0) {
            $stmt = $_db->prepare("INSERT INTO product_variation (product_id,size,color,stock_quantity,product_photo) VALUES (?,?,?,?,?)");
            $stmt->execute([$new_product_id, $new_size, $new_color, $new_quantity, $new_photo]);

            header('Location: ../page/product_maintenance.php');
            exit;
        }
    }
    
    // Display input field for add
    echo '<form action="" method="POST" enctype="multipart/form-data">';
    echo '<input type="hidden" name="action" value="add">';

    echo '<div class="category_div">';
    echo "<p class='color'>Photo: </p>";
    echo "<input type='file' name='product_photo'>";
    echo '</div>';

    echo '<div class="category_div">';
    echo "<p class='color'>Name: </p>";
    echo "<select name='product_name'>";
    foreach ($_product as $p) {
        echo "<option value='" . $p->name . "'>" . $p->name . "</option>";
    }
    echo "</select>";
    echo '</div>';
    echo '<div class="category_div">';
    echo "<p class='color'>Size: </p>";
    echo "<select name='product_size'>";
    foreach ($_size as $s) {
        echo "<option value='" . $s . "'>" . $s . "</option>";
    }
    echo "</select>";
    echo '</div>';
    echo '<div class="category_div">';
    echo "<p class='color'>Color: </p>";
    echo "<input type='text' name='product_color'>";
    echo '</div>';
    echo '<div class="name_div">';
    echo "<input type='number' name='product_quantity' placeholder='Product Quantity' step='1' min='0'>";
    echo '</div>';
    
    echo '<button type="submit" class="save_button">
                                <img class="delete_icon" src="/images/save.png">
                                    <p class="add">Add</p></button>';
    echo '</form>';
    echo "</div>";
    ?>
</div>

</html>

<?php
// Include the footer
include '../_foot.php';
?>
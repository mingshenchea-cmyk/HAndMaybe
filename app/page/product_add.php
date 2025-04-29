<?php
require '../_base.php';
//-----------------------------------------------------------------------------

// Get data
$_category = $_db->query('SELECT DISTINCT category FROM product')->fetchAll();

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
        $new_name = $_POST['product_name'];
        $new_name = ucwords(strtolower($new_name));

        $new_price = $_POST['product_price'];
        $new_price = number_format((float) $new_price, 2, '.', '');

        $new_description = $_POST['product_description'];
        // Capitalize the first letter of the first word
        $new_description = ucfirst(strtolower(trim($new_description)));

        // Ensure the sentence ends with a period
        if (substr($new_description, -1) !== '.') {
            $new_description .= '.';
        }

        $new_category = $_POST['product_category'];

        // Check if same name and same category already exist
        $check_stmt = $_db->prepare("SELECT COUNT(*) FROM product WHERE name = ? AND category = ?");
        $check_stmt->execute([$new_name, $new_category]);
        $count = $check_stmt->fetchColumn();

        if ($count == 0) {
            $stmt = $_db->prepare("INSERT INTO product (name, category, description, price, created_at) VALUES (?,?,?,?,NOW())");
            $stmt->execute([$new_name, $new_category, $new_description, $new_price]);

            header('Location: ../page/product_maintenance.php');
            exit;
        }
    }

    // Display input field for add
    echo '<form action="" method="POST" enctype="multipart/form-data">';
    echo '<input type="hidden" name="action" value="add">';

    echo '<div class="name_div">';
    echo "<input type='text' name='product_name' placeholder='Product Name'>";
    echo "<input type='number' name='product_price' placeholder='Product Price' step='0.1' min='0'>";
    echo "<textarea name='product_description' placeholder='Product Description' cols='90' rows='5'></textarea>";
    echo '</div>';
    echo '<div class="category_div">';
    echo "<p class='color'>Category: </p>";
    echo "<select name='product_category'>";
    foreach ($_category as $cat) {
        echo "<option value='" . $cat->category . "'>" . $cat->category . "</option>";
    }
    echo "</select>";
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
<?php

// ============================================================================
// PHP Setups
// ============================================================================

$_db = new PDO('mysql:dbname=h_and_maybe_db', 'root', '', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);

date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();

// ============================================================================
// General Page Functions
// ============================================================================

// Is GET request?
function is_get()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// Is POST request?
function is_post()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// Obtain GET parameter
function get($key, $value = null)
{
    $value = $_GET[$key] ?? $value;
    return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Obtain POST parameter
function post($key, $value = null)
{
    $value = $_POST[$key] ?? $value;
    return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Obtain REQUEST (GET and POST) parameter
function req($key, $value = null)
{
    $value = $_REQUEST[$key] ?? $value;
    return is_array($value) ? array_map('trim', $value) : trim($value);
}

// Redirect to URL
function redirect($url = null)
{
    $url ??= $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit();
}

// Set or get temporary session variable
function temp($key, $value = null)
{
    if ($value !== null) {
        $_SESSION["temp_$key"] = $value;
    } else {
        $value = $_SESSION["temp_$key"] ?? null;
        unset($_SESSION["temp_$key"]);
        return $value;
    }
}

// ============================================================================
// HTML Helpers
// ============================================================================

// Encode HTML special characters
function encode($value)
{
    return htmlentities($value);
}

// Generate <input type='text'>
function html_text($key, $attr = '')
{
    $value = encode($GLOBALS[$key] ?? '');
    echo "<input type='text' id='$key' name='$key' value='$value' $attr>";
}

// Generate <input type='radio'> list
function html_radios($key, $items, $br = false)
{
    $value = encode($GLOBALS[$key] ?? '');
    echo '<div>';
    foreach ($items as $id => $text) {
        $state = $id == $value ? 'checked' : '';
        echo "<label><input type='radio' id='{$key}_$id' name='$key' value='$id' $state>$text</label>";
        if ($br) {
            echo '<br>';
        }
    }
    echo '</div>';
}

// Generate <select>
function html_select($key, $items, $default = '- Select One -', $attr = '')
{
    $value = encode($GLOBALS[$key] ?? '');
    echo "<select id='$key' name='$key' $attr>";
    if ($default !== null) {
        echo "<option value=''>$default</option>";
    }
    foreach ($items as $id => $text) {
        $state = $id == $value ? 'selected' : '';
        echo "<option value='$id' $state>$text</option>";
    }
    echo '</select>';
}

// ============================================================================
// Error Handlings
// ============================================================================

// Global error array
$_err = [];

// Generate <span class='err'>
function err($key)
{
    global $_err;
    if ($_err[$key] ?? false) {
        echo "<span class='err'>$_err[$key]</span>";
    } else {
        echo '<span></span>';
    }
}

// ============================================================================
// Global Constants and Variables
// ============================================================================
// $_product = $_db->query('SELECT product_id, name FROM product')
//     ->fetchAll(PDO::FETCH_KEY_PAIR);

// print_r($_product);
//global $_db;
// ============================================================================
// Get Product function
// ============================================================================
function getAllProducts() {
    global $_db;
    return $_db->query('SELECT * FROM product')->fetchAll();
}

function getAllProductVariations() {
    global $_db;
    return $_db->query('SELECT * FROM product_variation')->fetchAll();
}

// ============================================================================
// Add to cart function
// ============================================================================
function add_to_cart($variation_id, $quantity = 1){
    $user_id = $_SESSION['user_id'];
    $cart_id = null;
    $variation_id = post('variation_id');
    $quantity = 1;

    if (!$user_id) {
        // If not logged in, redirect to login page
        header('Location: ../page/login.php');
        exit;
    }

    // Check if user already has a cart
    global $_db;
    $stmt = $_db->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);  // Bind $user_id to the query
    $cart = $stmt->fetch();  // Fetch the result

    if (!$cart) {
        $stmt = $_db->prepare("INSERT INTO cart (user_id, created_at) VALUES (?, NOW())");
        $stmt->execute([$user_id]);

        // Get the last inserted cart_id
        $cart_id = $_db->lastInsertId();
    } else {
        $cart_id = $cart->cart_id;
    }

    // Check if product already exists in cart_items
    $stmt = $_db->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND variation_id = ?");
    $stmt->execute([$cart_id, $variation_id]);
    $cart_item = $stmt->fetch();

    if ($cart_item) {
        // If item exists, update quantity
        $stmt = $_db->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE cart_item_id = ?");
        $stmt->execute([$quantity, $cart_item->cart_item_id]);

        // Set success message for updating quantity
        $_SESSION['cart_message'] = "Item quantity updated in your cart.";
    } else {
        // If item not exists, insert new item
        $stmt = $_db->prepare("INSERT INTO cart_items (cart_id, variation_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$cart_id, $variation_id, $quantity]);

        
        // Set success message for adding new item
        $_SESSION['cart_message'] = "Item added to your cart.";
    }

    // Redirect back to product page or cart page
    header('Location: ../page/product_detail.php');
    exit;
}
// ============================================================================
// Product Maintenance function
// ============================================================================
function updateProduct($product_id, $name, $price, $description, $category) {
    global $_db;
    $stmt = $_db->prepare("UPDATE product SET name = ?, price = ?, description = ?, category = ? WHERE product_id = ?");
    return $stmt->execute([$name, $price, $description, $category, $product_id]);
}

function updateProductVariation($product_id, $old_color, $new_color, $new_photo_path) {
    global $_db;
    $stmt = $_db->prepare("UPDATE product_variation SET color = ?, product_photo = ? WHERE product_id = ? AND color = ?");
    return $stmt->execute([$new_color, $new_photo_path, $product_id, $old_color]);
}

function deleteProductVariation($product_id, $color) {
    global $_db;
    $stmt = $_db->prepare("DELETE FROM product_variation WHERE product_id = ? AND color = ?");
    return $stmt->execute([$product_id, $color]);
}

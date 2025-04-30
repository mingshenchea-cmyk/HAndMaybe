<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H&Maybe | Women's, Men's & Kids' Fashion | H&Maybe MY</title>
    <link rel="icon" href="/images/HAndMaybe.png">
    <link rel="stylesheet" href="/css/handmaybe.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/handmaybe.js"></script>
</head>

<body>
    <header>
        <a href="/index.php">
            <img src="/images/HAndMaybe.png" class="logo" alt="H&Maybe Logo">
        </a>

        <div class="right-nav">
            <?php if (!$_user): ?>
                <a href="/page/security/login.php" class="nav-item">
                    <img src="/images/profile-icon.webp" alt="Sign In" class="nav-icon">
                    <p class="sign_in">Sign in</p>
                </a>
            <?php else: ?>
                <a href="/page/user/profile.php" class="nav-item">
                    <img src="/images/profile-icon.webp" alt="Profile" class="nav-icon">
                    <p class="profile">Profile</p>
                </a>
            <?php endif ?>
            <a href="/page/shopping_cart.php" class="nav-item">
                <img src="/images/118096.png" alt="Shopping Bag" class="nav-icon">
                <p class="cart">Shopping bag</p>
                <?php
                    $cart = get_cart();
                    $count = count($cart);
                    if ($count) echo "($count)";
                ?>
            </a>
        </div>
    </header>

    <?php 
        if ($currentPage == 'shoppingCart.php' || $currentPage == 'product.php' || $currentPage == 'index.php' || $currentPage == 'product_detail.php'): 
    ?>
        <nav>
            <div class="menu">
                <a href="../page/product.php?category=Women">Women</a>
                <a href="../page/product.php?category=Men">Men</a>
                <!-- <a href="/">Baby</a>
            <a href="/">Kids</a>
            <a href="/">Sale</a> -->
            </div>

            <div class="search">
                <form action="product.php" method="GET" class="search_product">
                    <img src="/images/search.jpg" class="search_icon">
                    <input type="text" name="query" placeholder="Search" id="searchInput">
                </form>
            </div>
        </nav>
    <?php endif; ?>

    <?php 
        if ($currentPage == 'product_add_variation.php' ||$currentPage == 'product_add.php' || $currentPage == 'member_maintenance.php' || $currentPage == 'product_maintenance.php' || $currentPage == 'order_maintenance.php' || $currentPage == 'product_maintenance_detail.php'):  
    ?>
        <nav>
            <div class="admin_menu">
                <a href="../page/member_maintenance.php">Member Maintenance</a>
                <a href="../page/product_maintenance.php">Product Maintenance</a>
                <a href="../page/order_maintenance.php">Order Maintenance</a>
            </div>

            <?php if ($currentPage == 'product_maintenance_detail.php' || $currentPage == 'product_maintenance.php'):?>
            <div class="search">
                <form action="product_maintenance.php" method="GET" class="search_product">
                    <img src="/images/search.jpg" class="search_icon">
                    <input type="text" name="query" placeholder="Search" id="searchInput">
                </form>
            </div>
            <?php endif; ?>
        </nav>
    <?php endif; ?>

    <main>
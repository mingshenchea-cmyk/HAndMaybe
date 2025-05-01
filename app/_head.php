<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$_category = getAllCategory();
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
        <div id="error"><?= temp('error') ?></div>
        <div id="info"><?= temp('info') ?></div>

        <a href="<?php if($_user?->role == "Admin")echo"/page/admin/member/member_maintenance.php"; else echo"/";?>">
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
            <?php if ($_user?->role != "Admin"): ?>
            <a href="/page/cart/shopping_cart.php" class="nav-item">
                <img src="/images/118096.png" alt="Shopping Bag" class="nav-icon">
                <p class="cart">Shopping bag</p>
                <?php
                    if($_user && $_user->role == "Member") {
                        $count = count_cart_items();
                        if ($count) echo "($count)";
                    }
                ?>
            </a>
            <?php endif ?>
            <?php if ($_user && $_user->role == "Member"): ?>
                <a href="/page/order/order_history.php" class="nav-item">
                    <img src="/images/orderhistoryicon.png" alt="Order History" class="nav-icon">
                    <p class="cart">Order History</p>
                </a>
            <?php endif; ?>

        </div>
    </header>

    <?php 
        if ($currentPage == 'shopping_cart.php' || $currentPage == 'product.php' || $currentPage == 'index.php' || $currentPage == 'product_detail.php'): 
    ?>
        <div class="nav-wrapper">
            <div class="menu">
                <a href="/page/product/product.php">View All</a>
                <?php foreach($_category as $categorys): ?>
                    <a href="/page/product/product.php?category=<?=$categorys->category_id?>"><?=$categorys->category?></a>
                <?php endforeach ?>
            </div>

            <?php if (in_array($currentPage, ['product.php', 'index.php', 'product_detail.php'])): ?>
            <div class="search">
                <form action="/page/product/product.php" method="GET" class="search_product">
                    <img src="/images/search.jpg" class="search_icon">
                    <input type="text" name="query" placeholder="Search" id="searchInput">
                </form>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php 
        if ($currentPage == 'product_add_variation.php' ||$currentPage == 'product_add.php' || $currentPage == 'member_maintenance.php' ||  $currentPage == 'member_detail.php' || $currentPage == 'product_maintenance.php' || $currentPage == 'order_maintenance.php' || $currentPage == 'product_maintenance_detail.php'):  
    ?>
        <nav>
            <div class="nav-wrapper">
                <div class="admin_menu">
                    <a href="/page/admin/member/member_maintenance.php">Member Maintenance</a>
                    <a href="/page/admin/product/product_maintenance.php">Product Maintenance</a>
                    <a href="/page/admin/order/order_maintenance.php">Order Maintenance</a>
                </div>

                <?php if ($currentPage == 'product_maintenance_detail.php' || $currentPage == 'product_maintenance.php'):?>
                <div class="search">
                    <form action="product_maintenance.php" method="GET" class="search_product">
                        <img src="/images/search.jpg" class="search_icon">
                        <input type="text" name="query" placeholder="Search" id="searchInput">
                    </form>
                </div>
                <?php endif; ?>

                <?php if ($currentPage == 'member_maintenance.php' || $currentPage == 'member_detail.php'):?>
                <div class="search">
                    <form action="member_maintenance.php" method="GET" class="search_product">
                        <img src="/images/search.jpg" class="search_icon">
                        <input type="text" name="query" placeholder="Search" id="searchInput">
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </nav>
    <?php endif; ?>

    <main>
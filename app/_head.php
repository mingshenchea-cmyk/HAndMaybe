<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H&Maybe | Women's, Men's & Kids' Fashion | H&Maybe MY</title>
    <link rel="icon" href="/images/HAndMaybe.png">
    <link rel="stylesheet" href="/css/handmaybe.css">
    <link rel="stylesheet" href="/css/product.css">
    <script src="/js/handmaybe.js"></script>
</head>

<!-- <?php
$currentPage = basename($_SERVER['PHP_SELF']);
?> -->

<body>
    <header>
        <img src="/images/HAndMaybe.png" class="logo" alt="H&Maybe Logo">

        <div class="right-nav">
            <a href="/" class="nav-item">
                <img src="/images/profile-icon.webp" alt="Sign In" class="nav-icon">
                <p class="sign_in">Sign in</p>
            </a>
            <a href="../page/shoppingCart.php" class="nav-item">
                <img src="/images/118096.png" alt="Shopping Bag" class="nav-icon">
                <p class="cart">Shopping bag (0)</p>
                <?php
                    $cart = get_cart();
                    $count = count($cart);
                    if ($count) echo "($count)";
                ?>
            </a>
        </div>
    </header>

    <?php if ($currentPage == 'product.php' || $currentPage == 'index.php' || $currentPage == 'product_detail.php'): ?>
        <nav>
            <div class="menu">
                <a href="../page/product.php?category=Women">Women</a>
                <a href="../page/product.php?category=Men">Men</a>
                <!-- <a href="/">Baby</a>
            <a href="/">Kids</a>
            <a href="/">Sale</a> -->
            </div>

            <div class="search">
                <img src="/images/search.jpg">
                <input type="text" name="query" placeholder="Search" id="searchInput">
                <!--<form action="search.php" method="GET">
                    <input type="text" name="query" placeholder="Search" id="searchInput">
                    <button type="submit">Search</button>
                </form> -->
            </div>
        </nav>
    <?php endif; ?>

    <main>
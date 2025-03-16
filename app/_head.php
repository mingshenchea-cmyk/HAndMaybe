<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H&Maybe | Women's, Men's & Kids' Fashion | H&Maybe MY</title>
    <link rel="icon" href="/images/HAndMaybe.png">
    <link rel="stylesheet" href="/css/handmaybe.css">
    <script src="/js/handmaybe.js"></script>
</head>

<!-- <?php
$currentPage = basename($_SERVER['PHP_SELF']);
?> -->

<body>
    <header>
        <img src="/images/HAndMaybe.png" class="logo">

        <div class="right-nav">
            <a href="/" class="nav-item">
                <img src="/images/profile-icon.webp" alt="Sign In">
                <p class="sign_in">Sign in</p>
            </a>
            <a href="../page/shoppingCart.php" class="nav-item" alt="Shopping Bag">
                <img src="/images/118096.png">
                <p class="cart">Shopping bag (0)</p>
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
                <input type="text" placeholder="Search">
            </div>
        </nav>
    <?php endif; ?>

    <main>
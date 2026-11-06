
<?php

require __DIR__ . "/../../layouts/header.php";

?>

<link rel="stylesheet" href="css/buyer/products.css">

<section class="products-page">

    <a href="index.php?page=buyer-dashboard" class="back-button">
        ← Back to Dashboard
    </a>

    <div class="products-heading">
        <div>
            <h1>Browse Products</h1>
            <p>Discover products available from Agora sellers.</p>
        </div>
    </div>

    <!-- Search Products -->
    <form action="index.php" method="GET" class="search-form">

        <input
            type="hidden"
            name="page"
            value="browse-products"
        >

        <input
            type="text"
            name="search"
            placeholder="Search products..."
            value="<?= htmlspecialchars($search) ?>"
        >

        <button type="submit">Search</button>

        <?php if ($search !== ""): ?>
            <a href="index.php?page=browse-products" class="clear-search">
                Clear
            </a>
        <?php endif; ?>

    </form>

    <!-- Product Results -->
    <div class="products-section">

        <div class="products-section-heading">
            <h2>
                <?= $search !== "" ? "Search Results" : "Available Products" ?>
            </h2>

            <span>
                <?= count($products) ?> product(s) found
            </span>
        </div>

        <?php if (empty($products)): ?>

            <div class="empty-products">
                <h3>No Products Found</h3>

                <p>
                    <?php if ($search !== ""): ?>
                        No products matched your search. Try another keyword.
                    <?php else: ?>
                        There are currently no products available.
                    <?php endif; ?>
                </p>
            </div>

        <?php else: ?>

            <div class="products-grid">

                <?php foreach ($products as $product): ?>

                    <div class="product-card">

                        <div class="product-placeholder">
                            <span>Product</span>
                        </div>

                        <div class="product-content">

                            <h3>
                                <?= htmlspecialchars($product["product_name"]) ?>
                            </h3>

                            <p class="product-description">
                                <?= htmlspecialchars($product["description"] ?? "") ?>
                            </p>

                            <!-- Business Name -->
                            <p class="product-business">
                                <span>Sold by:</span>

                                <?= htmlspecialchars(
                                    $product["business_name"] ?? "Independent Seller"
                                ) ?>
                            </p>

                            <div class="product-price">
                                $<?= number_format((float)$product["price"], 2) ?>
                            </div>

                            <div class="product-stock">

                                <?php if ((int)$product["quantity"] > 0): ?>

                                    <span class="in-stock">
                                        In Stock (<?= (int)$product["quantity"] ?>)
                                    </span>

                                <?php else: ?>

                                    <span class="out-of-stock">
                                        Out of Stock
                                    </span>

                                <?php endif; ?>

                            </div>

                            <a
                                href="index.php?page=product-details&id=<?= (int)$product['product_id'] ?>"
                                class="view-product-button"
                            >
                                View Product
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

<?php

require __DIR__ . "/../../layouts/footer.php";

?>

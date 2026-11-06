
<?php

require __DIR__ . "/../../layouts/header.php";

?>

<link rel="stylesheet" href="css/buyer/product-details.css">

<section class="product-details-page">

    <!-- Back Button -->
    <a href="index.php?page=browse-products" class="back-button">
        ← Back to Products
    </a>

    <!-- Purchase Feedback -->
    <?php if (isset($_GET["purchase"]) && $_GET["purchase"] === "success"): ?>

        <div class="success-message">
            Your purchase was completed successfully!
        </div>

    <?php elseif (isset($_GET["purchase"]) && $_GET["purchase"] === "failed"): ?>

        <div class="error-message">
            Purchase unsuccessful. The product may have insufficient stock.
            Please try again.
        </div>

    <?php endif; ?>

    <!-- Product Details -->
    <div class="product-details-card">

        <!-- Product Image Placeholder -->
        <div class="product-image">
            <span>Product</span>
        </div>

        <!-- Product Information -->
        <div class="product-information">

            <h1>
                <?= htmlspecialchars($product["product_name"]) ?>
            </h1>

            <p class="description">
                <?= htmlspecialchars($product["description"] ?? "") ?>
            </p>

            <h2 class="price">
                $<?= number_format((float)$product["price"], 2) ?>
            </h2>

            <!-- Stock Status -->
            <div class="stock">

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

            <!-- Purchase Form -->
            <?php if ((int)$product["quantity"] > 0): ?>

                <form
                    action="index.php?page=purchase-product"
                    method="POST"
                >

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?= (int)$product["product_id"] ?>"
                    >

                    <label for="quantity">
                        Quantity
                    </label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="1"
                        max="<?= (int)$product["quantity"] ?>"
                        value="1"
                        required
                    >

                    <button type="submit" class="purchase-button">
                        Purchase Product
                    </button>

                </form>

            <?php else: ?>

                <button class="purchase-button" disabled>
                    Currently Unavailable
                </button>

            <?php endif; ?>

        </div>

    </div>

</section>

<?php

require __DIR__ . "/../../layouts/footer.php";

?>

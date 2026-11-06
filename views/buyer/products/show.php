<?php

require __DIR__ . "/../../layouts/header.php";

?>

<link rel="stylesheet" href="css/buyer/product-details.css">

<section class="product-details-page">

    <a href="index.php?page=browse-products" class="back-button">
        ← Back to Products
    </a>

    <div class="product-details-card">

        <div class="product-image">
            <span>Product</span>
        </div>

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

            <?php if ((int)$product["quantity"] > 0): ?>

                <form action="index.php" method="GET">

                    <input
                        type="hidden"
                        name="page"
                        value="purchase-product"
                    >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int)$product["product_id"] ?>"
                    >

                    <label for="quantity">Quantity</label>

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
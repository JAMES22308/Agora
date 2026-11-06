
<?php

$pageTitle = "My Products - Agora";

require __DIR__ . "/../../layouts/header.php";

$success = "";
$error = "";

if (($_GET["success"] ?? "") === "added") {
    $success = "Product added successfully!";
} elseif (($_GET["success"] ?? "") === "updated") {
    $success = "Product updated successfully!";
} elseif (($_GET["success"] ?? "") === "deleted") {
    $success = "Product deleted successfully!";
}

if (isset($_GET["error"])) {
    $error = "The operation failed. Please check your details.";
}

?>

<link rel="stylesheet" href="css/seller/products.css">

<!-- Back to Dashboard -->
<div class="products-back-container">
    <a href="index.php?page=seller-dashboard" class="back-button">
        ← Back to Dashboard
    </a>
</div>

<section class="seller-products-page">

    <!-- Page Heading -->
    <div class="products-heading">

        <div>
            <h1>My Products</h1>
            <p>View and manage your product listings.</p>
        </div>

        <button type="button"
                class="add-product-button"
                onclick="openAddModal()">
            + Add New Product
        </button>

    </div>

    <!-- Success and Error Messages -->
    <?php if ($success !== ""): ?>
        <div class="success-message">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Products Table -->
    <div class="product-table-card">

        <div class="table-container">

            <table class="products-table">

                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($products)): ?>

                        <?php foreach ($products as $product): ?>

                            <tr>

                                <td>
                                    #<?= (int)$product["product_id"] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($product["product_name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($product["description"] ?? "") ?>
                                </td>

                                <td>
                                    $<?= number_format((float)$product["price"], 2) ?>
                                </td>

                                <td>
                                    <?= (int)$product["quantity"] ?>
                                </td>

                                <td class="product-actions">

                                    <!-- EDIT BUTTON -->
                                    <button
                                        type="button"
                                        class="edit-button"
                                        data-id="<?= (int)$product["product_id"] ?>"
                                        data-name="<?= htmlspecialchars($product["product_name"], ENT_QUOTES, "UTF-8") ?>"
                                        data-description="<?= htmlspecialchars($product["description"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                                        data-price="<?= htmlspecialchars((string)$product["price"], ENT_QUOTES, "UTF-8") ?>"
                                        data-quantity="<?= (int)$product["quantity"] ?>"
                                        onclick="openEditModal(this)">

                                        Edit

                                    </button>

                                    <!-- DELETE BUTTON -->
                                    <form
                                        action="index.php?page=delete-product"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');">

                                        <input
                                            type="hidden"
                                            name="product_id"
                                            value="<?= (int)$product["product_id"] ?>">

                                        <button type="submit" class="delete-button">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6">

                                <div class="empty-state">
                                    <h2>No Products Found</h2>
                                    <p>Add a product to get started.</p>
                                </div>

                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</section>


<!-- ======================================
     ADD PRODUCT POPUP
====================================== -->

<div class="product-modal" id="addProductModal">

    <div class="product-modal-content">

        <div class="modal-header">

            <div>
                <h2>Add New Product</h2>
                <p>Enter the details of your new product.</p>
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeAddModal()">
                &times;
            </button>

        </div>

        <form action="index.php?page=add-product" method="POST">

            <div class="form-group">
                <label for="product_name">Product Name</label>

                <input
                    type="text"
                    id="product_name"
                    name="product_name"
                    maxlength="150"
                    placeholder="Enter product name"
                    required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Enter product description"></textarea>
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="price">Price ($)</label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        min="0.01"
                        step="0.01"
                        placeholder="0.00"
                        required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        min="0"
                        step="1"
                        placeholder="0"
                        required>
                </div>

            </div>

            <div class="modal-actions">

                <button type="button"
                        class="cancel-button"
                        onclick="closeAddModal()">
                    Cancel
                </button>

                <button type="submit" class="save-product-button">
                    Save Product
                </button>

            </div>

        </form>

    </div>

</div>


<!-- ======================================
     EDIT PRODUCT POPUP
====================================== -->

<div class="product-modal" id="editProductModal">

    <div class="product-modal-content">

        <div class="modal-header">

            <div>
                <h2>Edit Product</h2>
                <p>Update your product details.</p>
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeEditModal()">
                &times;
            </button>

        </div>

        <form action="index.php?page=update-product" method="POST">

            <input
                type="hidden"
                name="product_id"
                id="edit_product_id">

            <div class="form-group">
                <label for="edit_product_name">Product Name</label>

                <input
                    type="text"
                    id="edit_product_name"
                    name="product_name"
                    maxlength="150"
                    required>
            </div>

            <div class="form-group">
                <label for="edit_description">Description</label>

                <textarea
                    id="edit_description"
                    name="description"
                    rows="4"></textarea>
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="edit_price">Price ($)</label>

                    <input
                        type="number"
                        id="edit_price"
                        name="price"
                        min="0.01"
                        step="0.01"
                        required>
                </div>

                <div class="form-group">
                    <label for="edit_quantity">Quantity</label>

                    <input
                        type="number"
                        id="edit_quantity"
                        name="quantity"
                        min="0"
                        step="1"
                        required>
                </div>

            </div>

            <div class="modal-actions">

                <button type="button"
                        class="cancel-button"
                        onclick="closeEditModal()">
                    Cancel
                </button>

                <button type="submit" class="save-product-button">
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


<!-- ======================================
     JAVASCRIPT
====================================== -->

<script>

function openAddModal() {
    document.getElementById("addProductModal").style.display = "flex";
}

function closeAddModal() {
    document.getElementById("addProductModal").style.display = "none";
}

function openEditModal(button) {

    document.getElementById("edit_product_id").value =
        button.dataset.id;

    document.getElementById("edit_product_name").value =
        button.dataset.name;

    document.getElementById("edit_description").value =
        button.dataset.description;

    document.getElementById("edit_price").value =
        button.dataset.price;

    document.getElementById("edit_quantity").value =
        button.dataset.quantity;

    document.getElementById("editProductModal").style.display = "flex";
}

function closeEditModal() {
    document.getElementById("editProductModal").style.display = "none";
}

// Close popups when clicking outside them
window.addEventListener("click", function(event) {

    const addModal = document.getElementById("addProductModal");
    const editModal = document.getElementById("editProductModal");

    if (event.target === addModal) {
        closeAddModal();
    }

    if (event.target === editModal) {
        closeEditModal();
    }

});

</script>

<?php require __DIR__ . "/../../layouts/footer.php"; ?>


<?php

$pageTitle = "Manage Sellers - Agora";

require __DIR__ . "/../layouts/header.php";

?>

<link rel="stylesheet" href="css/business/sellers.css">

<!-- BACK TO DASHBOARD -->

<div class="seller-back-container">

    <a href="index.php?page=business-dashboard" class="back-button">
        &larr; Back to Dashboard
    </a>

</div>


<!-- SELLERS PAGE -->

<section class="dashboard">

    <!-- PAGE HEADER -->

    <div class="seller-page-heading">

        <div>
            <h1>Business Sellers</h1>

            <p>
                View and manage sellers belonging to your business.
            </p>
        </div>

        <button
            type="button"
            class="add-seller-button"
            onclick="document.getElementById('addSellerModal').showModal()"
        >
            + Add New Seller
        </button>

    </div>


    <!-- SUCCESS AND ERROR MESSAGES -->

    <?php if (!empty($success)): ?>

        <p class="success-message">
            <?= htmlspecialchars($success) ?>
        </p>

    <?php endif; ?>

    <?php if (!empty($error)): ?>

        <p class="error-message">
            <?= htmlspecialchars($error) ?>
        </p>

    <?php endif; ?>


    <!-- SELLER TABLE -->

    <div class="card seller-table-card">

        <?php if (empty($sellers)): ?>

            <div class="empty-state">
                <h3>No Sellers Found</h3>
                <p>Add a seller to get started.</p>
            </div>

        <?php else: ?>

            <div class="table-container">

                <table>

                    <thead>
                        <tr>
                            <th>Seller ID</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Account Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($sellers as $seller): ?>

                            <tr>

                                <td>
                                    #<?= (int) $seller["user_id"] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($seller["full_name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($seller["email"]) ?>
                                </td>

                                <td>

                                    <?php if ($seller["is_active"] == 1): ?>

                                        <span class="status-badge status-active">
                                            Active
                                        </span>

                                    <?php else: ?>

                                        <span class="status-badge status-inactive">
                                            Inactive
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <form
                                        action="index.php?page=seller-status"
                                        method="POST"
                                    >

                                        <input
                                            type="hidden"
                                            name="seller_id"
                                            value="<?= (int) $seller["user_id"] ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="<?= $seller["is_active"] == 1 ? "0" : "1" ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="<?= $seller["is_active"] == 1 ? "deactivate-button" : "activate-button" ?>"
                                        >
                                            <?= $seller["is_active"] == 1
                                                ? "Deactivate"
                                                : "Activate" ?>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>


    <!-- ADD SELLER POPUP -->

    <dialog id="addSellerModal" class="seller-modal">

        <div class="modal-header">

            <div>
                <h2>Add New Seller</h2>
                <p>Create a seller account for your business.</p>
            </div>

            <button
                type="button"
                class="modal-close"
                onclick="document.getElementById('addSellerModal').close()"
                aria-label="Close"
            >
                &times;
            </button>

        </div>

        <form
            action="index.php?page=add-seller"
            method="POST"
        >

            <div class="form-group">

                <label for="full_name">Full Name</label>

                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    placeholder="Enter seller's full name"
                    maxlength="100"
                    required
                >

            </div>

            <div class="form-group">

                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter seller's email"
                    maxlength="150"
                    required
                >

            </div>

            <div class="form-group">

                <label for="password">Temporary Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimum 8 characters"
                    minlength="8"
                    required
                >

            </div>

            <div class="modal-actions">

                <button
                    type="button"
                    class="cancel-button"
                    onclick="document.getElementById('addSellerModal').close()"
                >
                    Cancel
                </button>

                <button type="submit" class="add-seller-button">
                    Add Seller
                </button>

            </div>

        </form>

    </dialog>

</section>

<?php require __DIR__ . "/../layouts/footer.php"; ?>

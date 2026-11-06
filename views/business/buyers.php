
<?php

$pageTitle = "Manage Buyers - Agora";

require __DIR__ . "/../layouts/header.php";

?>

<link rel="stylesheet" href="css/business/buyers.css">

<!-- Back to Dashboard -->
<div class="buyer-back-container">
    <a href="index.php?page=business-dashboard" class="back-button">
        &larr; Back to Dashboard
    </a>
</div>

<section class="dashboard">

    <!-- Page Heading -->
    <div class="buyer-page-heading">

        <div>
            <h1>Business Buyers</h1>
            <p>View and manage buyers belonging to your business.</p>
        </div>

        <button
            type="button"
            class="add-buyer-button"
            onclick="document.getElementById('addBuyerModal').showModal()"
        >
            + Add New Buyer
        </button>

    </div>

    <!-- Success Message -->
    <?php if (!empty($success)): ?>
        <div class="success-message">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Buyers Table -->
    <div class="buyer-table-card">

        <?php if (!empty($buyers)): ?>

            <div class="table-container">

                <table>

                    <thead>
                        <tr>
                            <th>Buyer ID</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Account Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($buyers as $buyer): ?>

                            <tr>

                                <td>
                                    #<?= htmlspecialchars($buyer["user_id"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($buyer["full_name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($buyer["email"]) ?>
                                </td>

                                <td>

                                    <?php if ($buyer["is_active"] == 1): ?>

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
                                        action="index.php?page=buyer-status"
                                        method="POST"
                                    >

                                        <input
                                            type="hidden"
                                            name="buyer_id"
                                            value="<?= htmlspecialchars($buyer["user_id"]) ?>"
                                        >

                                        <?php if ($buyer["is_active"] == 1): ?>

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="0"
                                            >

                                            <button
                                                type="submit"
                                                class="deactivate-button"
                                            >
                                                Deactivate
                                            </button>

                                        <?php else: ?>

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="1"
                                            >

                                            <button
                                                type="submit"
                                                class="activate-button"
                                            >
                                                Activate
                                            </button>

                                        <?php endif; ?>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty-state">
                <h3>No Buyers Found</h3>
                <p>Add a buyer to get started.</p>
            </div>

        <?php endif; ?>

    </div>

</section>


<!-- Add Buyer Modal -->
<dialog id="addBuyerModal" class="buyer-modal">

    <div class="modal-header">

        <h2>Add New Buyer</h2>

        <button
            type="button"
            class="modal-close"
            onclick="document.getElementById('addBuyerModal').close()"
        >
            &times;
        </button>

    </div>

    <form
        action="index.php?page=add-buyer"
        method="POST"
    >

        <div class="form-group">

            <label for="buyer_full_name">
                Full Name
            </label>

            <input
                type="text"
                id="buyer_full_name"
                name="full_name"
                placeholder="Enter buyer's full name"
                required
            >

        </div>

        <div class="form-group">

            <label for="buyer_email">
                Email Address
            </label>

            <input
                type="email"
                id="buyer_email"
                name="email"
                placeholder="Enter buyer's email"
                required
            >

        </div>

        <div class="form-group">

            <label for="buyer_password">
                Password
            </label>

            <input
                type="password"
                id="buyer_password"
                name="password"
                placeholder="Enter buyer's password"
                minlength="8"
                required
            >

        </div>

        <div class="modal-actions">

            <button
                type="button"
                class="cancel-button"
                onclick="document.getElementById('addBuyerModal').close()"
            >
                Cancel
            </button>

            <button type="submit">
                Create Buyer
            </button>

        </div>

    </form>

</dialog>


<?php require __DIR__ . "/../layouts/footer.php"; ?>

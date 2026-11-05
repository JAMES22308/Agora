
<?php

$pageTitle = "Manage Sellers - Agora";

require __DIR__ . "/../layouts/header.php";

?>
<link rel="stylesheet" href="css/business/sellers.css">

<section class="dashboard">

    <div class="dashboard-heading">

        <h1>Manage Sellers</h1>

        <p>
            Add and manage sellers belonging to your business.
        </p>

    </div>

    <?php if (!empty($success)): ?>

        <p class="success-message">
            <?php echo htmlspecialchars($success); ?>
        </p>

    <?php endif; ?>

    <?php if (!empty($error)): ?>

        <p class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <!-- ADD SELLER FORM -->

    <div class="card">

        <h2>Add New Seller</h2>

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
                    required
                >

            </div>

            <div class="form-group">

                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >

            </div>

            <div class="form-group">

                <label for="password">Temporary Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    minlength="8"
                    required
                >

            </div>

            <button type="submit">
                Add Seller
            </button>

        </form>

    </div>


    <!-- SELLER LIST -->

    <div class="card" style="margin-top: 25px;">

        <h2>Business Sellers</h2>

        <?php if (empty($sellers)): ?>

            <p>No sellers have been added to your business yet.</p>

        <?php else: ?>

            <div class="table-container">

                <table>

                    <thead>

                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($sellers as $seller): ?>

                            <tr>

                                <td>
                                    <?php echo htmlspecialchars($seller["full_name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($seller["email"]); ?>
                                </td>

                                <td>

                                    <?php if ($seller["is_active"] == 1): ?>

                                        <span class="status-active">Active</span>

                                    <?php else: ?>

                                        <span class="status-inactive">Inactive</span>

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
                                            value="<?php echo (int) $seller["user_id"]; ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="<?php echo $seller["is_active"] == 1 ? "0" : "1"; ?>"
                                        >

                                        <button type="submit">

                                            <?php echo $seller["is_active"] == 1
                                                ? "Deactivate"
                                                : "Activate"; ?>

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

</section>

<?php require __DIR__ . "/../layouts/footer.php"; ?>

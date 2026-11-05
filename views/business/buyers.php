
<?php

require __DIR__ . "/../layouts/header.php";

?>

<link rel="stylesheet" href="css/business/buyers.css">

<section class="dashboard-heading">

    <h1>Manage Buyers</h1>

    <p>Manage buyer accounts belonging to your business.</p>

</section>


<!-- SUCCESS MESSAGE -->

<?php if (!empty($success)): ?>

    <div class="success-message">
        <?php echo htmlspecialchars($success); ?>
    </div>

<?php endif; ?>


<!-- ERROR MESSAGE -->

<?php if (!empty($error)): ?>

    <div class="error-message">
        <?php echo htmlspecialchars($error); ?>
    </div>

<?php endif; ?>


<!-- ADD BUYER FORM -->

<section class="card">

    <h2>Add New Buyer</h2>

    <form action="index.php?page=add-buyer" method="POST">

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

            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                required
            >

        </div>


        <button type="submit">
            Add Buyer
        </button>

    </form>

</section>


<!-- BUYERS TABLE -->

<section class="card">

    <h2>Business Buyers</h2>

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

                <?php if (count($buyers) > 0): ?>

                    <?php foreach ($buyers as $buyer): ?>

                        <tr>

                            <td>
                                <?php echo htmlspecialchars($buyer["full_name"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($buyer["email"]); ?>
                            </td>

                            <td>

                                <?php if ($buyer["is_active"] == 1): ?>

                                    <span class="status-active">
                                        Active
                                    </span>

                                <?php else: ?>

                                    <span class="status-inactive">
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
                                        value="<?php echo $buyer["user_id"]; ?>"
                                    >

                                    <?php if ($buyer["is_active"] == 1): ?>

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="0"
                                        >

                                        <button type="submit">
                                            Deactivate
                                        </button>

                                    <?php else: ?>

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="1"
                                        >

                                        <button type="submit">
                                            Activate
                                        </button>

                                    <?php endif; ?>

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="4">
                            No buyers found for this business.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php

require __DIR__ . "/../layouts/footer.php";

?>

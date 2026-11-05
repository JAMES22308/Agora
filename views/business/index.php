
<?php

$pageTitle = "Business Dashboard - Agora";

require __DIR__ . "/../layouts/header.php";

?>

<section class="dashboard">

    <div class="dashboard-heading">
        <h1>Business Dashboard</h1>

        <p>
            Welcome to your business management portal.
        </p>
    </div>

    <?php if (!empty($business)): ?>

        <div class="card business-information">

            <h2>
                <?php echo htmlspecialchars($business["business_name"]); ?>
            </h2>

            <p>
                Manage your business information, buyers and sellers
                from this dashboard.
            </p>

        </div>

    <?php else: ?>

        <div class="card">
            <p>No business account has been assigned to your account.</p>
        </div>

    <?php endif; ?>

    <h2 class="dashboard-section-title">Business Management</h2>

    <div class="dashboard-grid">

        <div class="card">

            <h3>Business Profile</h3>

            <p>
                View and update your business information and logo.
            </p>

        </div>

        <div class="card">

            <h3>Manage Sellers</h3>

            <p>
                Add sellers, activate accounts and manage
                sellers belonging to your business.
            </p>

        </div>

        <div class="card">

            <h3>Manage Buyers</h3>

            <p>
                Add buyers, activate accounts and manage
                buyers belonging to your business.
            </p>

        </div>

    </div>

</section>

<?php require __DIR__ . "/../layouts/footer.php"; ?>

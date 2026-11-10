
<?php

$pageTitle = "Business Dashboard - Agora";

require __DIR__ . "/../layouts/header.php";

?>

<link rel="stylesheet" href="css/business/index.css">

<section class="dashboard">

    <div class="dashboard-heading">
        <h1>Business Dashboard</h1>

        <p>
            Welcome to your business management portal.
        </p>
    </div>

    <?php if (!empty($business)): ?>

        <div class="card business-information">

            <div class="business-branding">

                <?php if (!empty($business["logo"])): ?>

                    <img
                        src="<?= htmlspecialchars($business["logo"]) ?>"
                        alt="Business Logo"
                        class="dashboard-business-logo"
                    >

                <?php else: ?>

                    <div class="dashboard-logo-placeholder">
                        <span>No Logo</span>
                    </div>

                <?php endif; ?>

                <div class="business-details">

                    <h2>
                        <?= htmlspecialchars($business["business_name"]) ?>
                    </h2>

                    <p>
                        Manage your business information, buyers and sellers
                        from this dashboard.
                    </p>

                </div>

            </div>

        </div>

    <?php else: ?>

        <div class="card">
            <p>No business account has been assigned to your account.</p>
        </div>

    <?php endif; ?>

    <h2 class="dashboard-section-title">Business Management</h2>

    <div class="dashboard-grid">

        <!-- BUSINESS PROFILE -->

        <a href="index.php?page=business-profile" class="card dashboard-link">

            <h3>Business Profile</h3>

            <p>
                View and update your business information and logo.
            </p>

        </a>

        <!-- MANAGE SELLERS -->

        <a href="index.php?page=manage-sellers" class="card dashboard-link">

            <h3>Manage Sellers</h3>

            <p>
                Add sellers, activate accounts and manage
                sellers belonging to your business.
            </p>

        </a>

        <!-- MANAGE BUYERS -->

        <a href="index.php?page=manage-buyers" class="card dashboard-link">

            <h3>Manage Buyers</h3>

            <p>
                Add buyers, activate accounts and manage
                buyers belonging to your business.
            </p>

        </a>

    </div>

</section>

<?php require __DIR__ . "/../layouts/footer.php"; ?>

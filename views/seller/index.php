
<?php

$pageTitle = "Seller Dashboard - Agora";

require __DIR__ . "/../layouts/header.php";

?>

<link rel="stylesheet" href="css/seller/index.css">

<section class="seller-dashboard">

    <!-- Welcome Section -->
    <div class="seller-welcome">
        <div>
            <h1>Seller Dashboard</h1>

            <p>
                Welcome back,
                <?= htmlspecialchars($_SESSION["full_name"]) ?>!
            </p>

            <span>
                Manage your seller profile and product listings.
            </span>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="seller-dashboard-grid">

        <!-- Profile -->
        <a
            href="index.php?page=seller-profile"
            class="seller-card"
        >
            <div class="seller-card-icon">👤</div>

            <h2>My Profile</h2>

            <p>
                View and update your personal information.
            </p>
        </a>

        <!-- Products -->
        <a
            href="index.php?page=my-products"
            class="seller-card"
        >
            <div class="seller-card-icon">📦</div>

            <h2>My Products</h2>

            <p>
                View and manage your product listings.
            </p>
        </a>

      
    </div>

</section>

<?php require __DIR__ . "/../layouts/footer.php"; ?>

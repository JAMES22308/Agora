
<?php

require __DIR__ . "/../layouts/header.php";

?>

<link rel="stylesheet" href="css/buyer/dashboard.css">

<section class="dashboard-heading">
    <h1>Buyer Dashboard</h1>
    <p>Welcome to Agora. Browse products and manage your purchases.</p>
</section>

<section class="buyer-dashboard">

    <!-- My Profile -->
    <div class="dashboard-card">
        <h2>My Profile</h2>
        <p>View and update your account information.</p>

        <a href="index.php?page=buyer-profile" class="dashboard-button">
            View Profile
        </a>
    </div>

    <!-- Browse Products -->
    <div class="dashboard-card">
        <h2>Browse Products</h2>
        <p>Explore products available from Agora sellers.</p>

        <a href="index.php?page=browse-products" class="dashboard-button">
            Browse Products
        </a>
    </div>

    <!-- My Orders -->
    <div class="dashboard-card">
        <h2>My Orders</h2>
        <p>View and track your purchases.</p>

        <a href="index.php?page=my-orders" class="dashboard-button">
            View My Orders
        </a>
    </div>

</section>

<?php

require __DIR__ . "/../layouts/footer.php";

?>

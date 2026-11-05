
<?php
$pageTitle = "Agora - Online Marketplace";
require __DIR__ . "/layouts/header.php";
?>

<section class="home-section">

    <div class="home-content">

        <h1>Welcome to Agora</h1>

        <p>
            Your online marketplace to discover products,
            connect with businesses and grow your sales.
        </p>

        <div class="home-buttons">

            <a href="index.php?page=register">
                <button type="button">Get Started</button>
            </a>

            <a href="index.php?page=login">
                <button type="button" class="secondary-button">
                    Login
                </button>
            </a>

        </div>

    </div>

</section>

<section class="home-features">

    <h2>What can you do with Agora?</h2>

    <div class="feature-grid">

        <div class="card">
            <h3>For Buyers</h3>
            <p>
                Browse products, explore businesses
                and purchase items online.
            </p>
        </div>

        <div class="card">
            <h3>For Sellers</h3>
            <p>
                Manage your products, update listings
                and reach more customers.
            </p>
        </div>

        <div class="card">
            <h3>For Businesses</h3>
            <p>
                Manage your business account and
                connect buyers and sellers.
            </p>
        </div>

    </div>

</section>

<?php require __DIR__ . "/layouts/footer.php"; ?>

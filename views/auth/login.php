
<?php
$pageTitle = "Login - Agora";
require __DIR__ . "/../layouts/header.php";
?>

<section class="auth-container">

    <div class="auth-card">

        <h1>Welcome Back</h1>

        <p>Log in to your Agora account.</p>

        <?php if (!empty($error)): ?>
            <p class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST">

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
                    required
                >
            </div>

            <button type="submit">Login</button>

        </form>

        <p>
            Don't have an account?
            <a href="index.php?page=register">Register here</a>
        </p>

    </div>

</section>

<?php require __DIR__ . "/../layouts/footer.php"; ?>


<?php
$pageTitle = "Register - Agora";
require __DIR__ . "/../layouts/header.php";
?>

<section class="auth-container">

    <div class="auth-card">

        <h1>Create an Account</h1>

        <p>Join Agora and start shopping or selling.</p>

        <?php if (!empty($error)): ?>
            <p class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form action="index.php?page=register" method="POST">

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
                    required
                >
            </div>

            <div class="form-group">
                <label for="role">Account Type</label>

                <select id="role" name="role" required>
                    <option value="">Select Account Type</option>
                    <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                </select>
            </div>

            <button type="submit">Create Account</button>

        </form>

        <p>
            Already have an account?
            <a href="index.php?page=login">Login here</a>
        </p>

    </div>

</section>

<?php require __DIR__ . "/../layouts/footer.php"; ?>

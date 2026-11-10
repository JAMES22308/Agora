
<?php
$pageTitle = "Register - Agora";
require __DIR__ . "/../layouts/header.php";
?>

<section class="auth-container">

    <div class="auth-card">

        <h1>Create a Buyer Account</h1>

        <p>Join Agora and start shopping.</p>

        <?php if (!empty($error)): ?>
            <p class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success-message">
                <?php echo htmlspecialchars($success); ?>
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
                    minlength="8"
                    required
                >
            </div>

            <div class="form-group">
                <label for="business_id">Select Business</label>

                <select id="business_id" name="business_id" required>
                    <option value="">Choose a business</option>

                    <?php foreach ($businesses as $business): ?>
                        <option value="<?php echo htmlspecialchars($business["business_id"]); ?>">
                            <?php echo htmlspecialchars($business["business_name"]); ?>
                        </option>
                    <?php endforeach; ?>

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

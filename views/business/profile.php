
<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<link rel="stylesheet" href="css/business/profile.css">

<section class="business-profile-page">

    <div class="page-heading">
        <div>
            <h1>Business Profile</h1>
            <p>View and update your business information.</p>
        </div>

        <a href="index.php?page=business-dashboard" class="back-link">
            Back to Dashboard
        </a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="message success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="message error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($business): ?>

        <div class="profile-card">

            <h2>Business Information</h2>

            <form
                action="index.php?page=update-business-profile"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="logo-section">

                    <label>Business Logo</label>

                    <?php if (!empty($business["logo"])): ?>

                        <img
                            src="<?= htmlspecialchars($business["logo"]) ?>"
                            alt="Business Logo"
                            class="business-logo"
                        >

                    <?php else: ?>

                        <div class="logo-placeholder">
                            No logo uploaded
                        </div>

                    <?php endif; ?>

                    <input
                        type="file"
                        name="logo"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small>
                        Accepted formats: JPG, PNG and WebP.
                        Maximum size: 2 MB.
                    </small>

                </div>

                <div class="form-group">

                    <label for="business_name">
                        Business Name
                    </label>

                    <input
                        type="text"
                        id="business_name"
                        name="business_name"
                        value="<?= htmlspecialchars($business["business_name"]) ?>"
                        maxlength="100"
                        required
                    >

                </div>

                <button type="submit">
                    Save Changes
                </button>

            </form>

        </div>

    <?php else: ?>

        <div class="message error">
            Business information could not be found.
        </div>

    <?php endif; ?>

</section>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>


<?php

require __DIR__ . "/../../layouts/header.php";

// Get seller information
$fullName = htmlspecialchars($seller["full_name"] ?? "");
$email = htmlspecialchars($seller["email"] ?? "");
$role = ucfirst(htmlspecialchars($seller["role"] ?? "Seller"));

?>

<link rel="stylesheet" href="css/seller/profile.css">

<div class="profile-page">

    <a href="index.php?page=seller-dashboard" class="back-link">
        &larr; Back to Dashboard
    </a>

    <div class="profile-heading">
        <div>
            <h1>My Profile</h1>
            <p>View and manage your seller account information.</p>
        </div>

        <span class="account-badge">
            Seller Account
        </span>
    </div>


    <?php if (!empty($_GET["success"])): ?>

        <div class="alert alert-success">
            Your profile has been updated successfully!
        </div>

    <?php endif; ?>


    <?php if (!empty($_GET["error"])): ?>

        <div class="alert alert-error">
            Unable to update your profile. Please check your details.
        </div>

    <?php endif; ?>


    <section class="profile-card">

        <div class="profile-overview">

            <div class="profile-avatar">
                <?= strtoupper(substr($fullName, 0, 1)) ?>
            </div>

            <div class="profile-identity">
                <h2><?= $fullName ?></h2>
                <p><?= $email ?></p>
                <span><?= $role ?></span>
            </div>

            <button
                type="button"
                class="edit-profile-button"
                onclick="openProfileModal()"
            >
                Edit Profile
            </button>

        </div>


        <div class="profile-divider"></div>


        <div class="personal-information">

            <h3>Personal Information</h3>

            <div class="information-grid">

                <div class="information-item">
                    <label>Full Name</label>
                    <p><?= $fullName ?></p>
                </div>

                <div class="information-item">
                    <label>Email Address</label>
                    <p><?= $email ?></p>
                </div>

                <div class="information-item">
                    <label>Account Role</label>
                    <p><?= $role ?></p>
                </div>

                <div class="information-item">
                    <label>Account ID</label>
                    <p>#<?= (int) $seller["user_id"] ?></p>
                </div>

            </div>

        </div>

    </section>

</div>


<!-- ======================================
     EDIT PROFILE MODAL
====================================== -->

<div class="modal-overlay" id="profileModal">

    <div class="profile-modal">

        <div class="modal-header">

            <div>
                <h2>Edit Profile</h2>
                <p>Update your personal information.</p>
            </div>

            <button
                type="button"
                class="modal-close"
                onclick="closeProfileModal()"
            >
                &times;
            </button>

        </div>


        <form
            action="index.php?page=update-seller-profile"
            method="POST"
        >

            <div class="form-group">

                <label for="full_name">Full Name</label>

                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    value="<?= $fullName ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= $email ?>"
                    required
                >

            </div>


            <div class="modal-actions">

                <button
                    type="button"
                    class="cancel-button"
                    onclick="closeProfileModal()"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="save-button"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


<script>

function openProfileModal() {
    document.getElementById("profileModal").classList.add("active");
}

function closeProfileModal() {
    document.getElementById("profileModal").classList.remove("active");
}

document.getElementById("profileModal").addEventListener("click", function(event) {

    if (event.target === this) {
        closeProfileModal();
    }

});

document.addEventListener("keydown", function(event) {

    if (event.key === "Escape") {
        closeProfileModal();
    }

});

</script>


/* <?php require __DIR__ . "/../../layouts/footer.php"; ?> */

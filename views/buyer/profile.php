
<?php

require __DIR__ . "/../layouts/header.php";

$fullName = $buyer["full_name"] ?? "";
$email = $buyer["email"] ?? "";
$initials = strtoupper(substr(trim($fullName), 0, 1));

?>

<link rel="stylesheet" href="css/buyer/profile.css">

<div class="profile-page">

    <a href="index.php?page=buyer-dashboard" class="back-link">
        &larr; Back to Dashboard
    </a>

    <div class="profile-heading">
        <div>
            <h1>My Profile</h1>
            <p>Manage your personal information and account details.</p>
        </div>

        <span class="account-badge">Buyer Account</span>
    </div>

    <?php if (!empty($success)): ?>
        <div class="alert success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <section class="profile-card">

        <!-- Profile Header -->
        <div class="profile-card-header">

            <div class="profile-avatar">
                <?= htmlspecialchars($initials) ?>
            </div>

            <div class="profile-identity">
                <h2><?= htmlspecialchars($fullName) ?></h2>
                <p><?= htmlspecialchars($email) ?></p>
                <span>Buyer</span>
            </div>

            <button
                type="button"
                class="edit-button"
                onclick="openEditModal()"
            >
                Edit Profile
            </button>

        </div>

        <div class="profile-divider"></div>

        <!-- Personal Information -->
        <div class="personal-information">

            <h3>Personal Information</h3>

            <div class="information-grid">

                <div class="information-item">
                    <label>Full Name</label>
                    <p><?= htmlspecialchars($fullName) ?></p>
                </div>

                <div class="information-item">
                    <label>Email Address</label>
                    <p><?= htmlspecialchars($email) ?></p>
                </div>

                <div class="information-item">
                    <label>Account Role</label>
                    <p>Buyer</p>
                </div>

                <div class="information-item">
                    <label>Account ID</label>
                    <p>#<?= htmlspecialchars($buyer["user_id"]) ?></p>
                </div>

            </div>

        </div>

    </section>

</div>


<!-- Edit Profile Modal -->
<div class="modal-overlay" id="editProfileModal">

    <div class="profile-modal">

        <div class="modal-header">
            <div>
                <h2>Edit Profile</h2>
                <p>Update your personal information.</p>
            </div>

            <button
                type="button"
                class="close-button"
                onclick="closeEditModal()"
            >
                &times;
            </button>
        </div>

        <form
            action="index.php?page=update-buyer-profile"
            method="POST"
        >

            <div class="modal-body">

                <div class="form-group">
                    <label for="full_name">Full Name</label>

                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="<?= htmlspecialchars($fullName) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($email) ?>"
                        required
                    >
                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="cancel-button"
                    onclick="closeEditModal()"
                >
                    Cancel
                </button>

                <button type="submit" class="save-button">
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>


<script>

function openEditModal() {
    document.getElementById("editProfileModal").classList.add("active");
}

function closeEditModal() {
    document.getElementById("editProfileModal").classList.remove("active");
}

document.getElementById("editProfileModal").addEventListener("click", function(event) {
    if (event.target === this) {
        closeEditModal();
    }
});

document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        closeEditModal();
    }
});

</script>

<?php

require __DIR__ . "/../layouts/footer.php";

?>

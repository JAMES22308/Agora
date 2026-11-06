
<?php

require_once __DIR__ . "/../models/User.php";

class BuyerController
{
    private $userModel;

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
    }

    // Display buyer profile
   public function profile()
{
    if (
        !isset($_SESSION["user_id"]) ||
        ($_SESSION["role"] ?? "") !== "buyer"
    ) {
        header("Location: index.php?page=login");
        exit;
    }

    $buyer = $this->userModel->findById($_SESSION["user_id"]);

    $success = "";
    $error = "";

    if (isset($_GET["success"])) {
        $success = "Your profile has been updated successfully!";
    }

    if (isset($_GET["error"])) {
        $error = "Unable to update your profile. Please check your details.";
    }

    require __DIR__ . "/../views/buyer/profile.php";
}

    // Update buyer profile
    public function updateProfile($fullName, $email)
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "buyer"
        ) {
            return false;
        }

        $fullName = trim($fullName);
        $email = trim($email);

        if (
            $fullName === "" ||
            !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            return false;
        }

        return $this->userModel->updateProfile(
            $_SESSION["user_id"],
            $fullName,
            $email
        );
    }
}

?>

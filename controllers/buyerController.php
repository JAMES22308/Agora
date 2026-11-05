
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
            $_SESSION["role"] !== "buyer"
        ) {
            http_response_code(403);
            exit("Access denied.");
        }

        $buyer = $this->userModel->findById(
            $_SESSION["user_id"]
        );

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

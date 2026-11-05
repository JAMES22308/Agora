
<?php

require_once __DIR__ . "/../models/User.php";

class SellerController
{
    private $userModel;

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
    }

    // Display seller profile
    public function profile()
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "seller"
        ) {
            http_response_code(403);
            exit("Access denied.");
        }

        $seller = $this->userModel->findById(
            $_SESSION["user_id"]
        );

        require __DIR__ . "/../views/seller/profile.php";
    }

    // Update seller profile
    public function updateProfile($fullName, $email)
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "seller"
        ) {
            return false;
        }

        $fullName = trim($fullName);
        $email = trim($email);

        if ($fullName === "" || $email === "") {
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

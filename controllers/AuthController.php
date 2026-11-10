
<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Business.php";

class AuthController
{
    private $userModel;
    private $businessModel;

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
        $this->businessModel = new Business($conn);
    }

    // Log in an existing user
    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return false;
        }

        if ($user["is_active"] != 1) {
            return false;
        }

        if (!password_verify($password, $user["password"])) {
            return false;
        }

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["full_name"] = $user["full_name"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["business_id"] = $user["business_id"];

        return true;
    }

    // Register a new buyer
    public function register($fullName, $email, $password, $businessId)
    {
        $fullName = trim($fullName);
        $email = trim($email);

        if (
            $fullName === "" ||
            $email === "" ||
            $password === "" ||
            $businessId === ""
        ) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (strlen($password) < 8) {
            return false;
        }

        if ($this->userModel->findByEmail($email)) {
            return false;
        }

        // Validate that the selected business exists
        $businessId = filter_var($businessId, FILTER_VALIDATE_INT);

        if (!$businessId || !$this->businessModel->findById($businessId)) {
            return false;
        }

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Public registration is for buyers only
        return $this->userModel->createBuyerForBusiness(
            $businessId,
            $fullName,
            $email,
            $passwordHash
        );
    }

    // Log out the current user
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }
}

?>

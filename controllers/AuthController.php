
<?php

require_once __DIR__ . "/../models/User.php";

class AuthController
{
    private $userModel;

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
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

    // Register a new user
    public function register($fullName, $email, $password, $role)
    {
        $fullName = trim($fullName);
        $email = trim($email);

        // Check required fields
        if (
            $fullName === "" ||
            $email === "" ||
            $password === ""
        ) {
            return false;
        }

        // Check email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Allow only buyer and seller registration
        if (!in_array($role, ["buyer", "seller"])) {
            return false;
        }

        // Check password length
        if (strlen($password) < 8) {
            return false;
        }

        // Check whether email already exists
        if ($this->userModel->findByEmail($email)) {
            return false;
        }

        // Hash the password
        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // Save the new user
        return $this->userModel->create(
            $fullName,
            $email,
            $passwordHash,
            $role
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

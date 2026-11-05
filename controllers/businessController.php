
<?php

require_once __DIR__ . "/../models/Business.php";
require_once __DIR__ . "/../models/User.php";

class BusinessController
{
    private $businessModel;
    private $userModel;

    public function __construct($conn)
    {
        $this->businessModel = new Business($conn);
        $this->userModel = new User($conn);
    }

    // Check whether the user is a Business Admin
    private function checkBusinessAdmin()
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "business_admin" ||
            empty($_SESSION["business_id"])
        ) {
            http_response_code(403);
            exit("Access denied.");
        }
    }

    // Display the business dashboard
    public function index()
    {
        $this->checkBusinessAdmin();

        $businessId = $_SESSION["business_id"];

        $business = $this->businessModel->findById($businessId);

        require __DIR__ . "/../views/business/index.php";
    }

    // Update business information
    public function update($businessName)
    {
        $this->checkBusinessAdmin();

        $businessId = $_SESSION["business_id"];

        $businessName = trim($businessName);

        if ($businessName === "") {
            return false;
        }

        return $this->businessModel->update(
            $businessId,
            $businessName
        );
    }

    // Display sellers belonging to this business
    public function manageSellers()
    {
        $this->checkBusinessAdmin();

        $businessId = $_SESSION["business_id"];

        $sellers = $this->userModel->getSellersByBusiness(
            $businessId
        );

        require __DIR__ . "/../views/business/sellers.php";
    }

    // Add a new seller to this business
    public function addSeller($fullName, $email, $password)
    {
        $this->checkBusinessAdmin();

        $businessId = $_SESSION["business_id"];

        $fullName = trim($fullName);
        $email = trim($email);

        if (
            $fullName === "" ||
            $email === "" ||
            $password === ""
        ) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (strlen($password) < 8) {
            return false;
        }

        // Check whether the email already exists
        if ($this->userModel->findByEmail($email)) {
            return false;
        }

        // Hash the password before saving it
        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        return $this->userModel->createSellerForBusiness(
            $businessId,
            $fullName,
            $email,
            $passwordHash
        );
    }

    // Activate or deactivate a seller
    public function changeSellerStatus($sellerId, $status)
    {
        $this->checkBusinessAdmin();

        if (!in_array($status, ["0", "1"], true)) {
            return false;
        }

        $businessId = $_SESSION["business_id"];

        return $this->userModel->updateSellerStatus(
            $sellerId,
            $businessId,
            (int) $status
        );
    }
}

?>

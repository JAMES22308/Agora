
<?php

require_once __DIR__ . "/../models/Business.php";

class BusinessController
{
    private $businessModel;

    public function __construct($conn)
    {
        $this->businessModel = new Business($conn);
    }

    // Display the business dashboard
    public function index()
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "business_admin"
        ) {
            header("Location: index.php?page=login");
            exit;
        }

        $businessId = $_SESSION["business_id"];

        $business = $this->businessModel->findById($businessId);

        require __DIR__ . "/../views/business/index.php";
    }

    // Update business information
    public function update($businessName)
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "business_admin"
        ) {
            http_response_code(403);
            exit("Access denied.");
        }

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
}

?>

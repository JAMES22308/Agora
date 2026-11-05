
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
            ($_SESSION["role"] ?? "") !== "business_admin" ||
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

    // Display business profile
    public function profile($success = "", $error = "")
    {
        $this->checkBusinessAdmin();

        $businessId = $_SESSION["business_id"];

        $business = $this->businessModel->findById($businessId);

        require __DIR__ . "/../views/business/profile.php";
    }

    // Update business profile
    public function updateProfile($businessName, $logo)
    {
        $this->checkBusinessAdmin();

        $businessId = $_SESSION["business_id"];

        $businessName = trim($businessName);

        if ($businessName === "") {
            return [
                "success" => false,
                "message" => "Business name is required."
            ];
        }

        if (strlen($businessName) > 100) {
            return [
                "success" => false,
                "message" => "Business name cannot exceed 100 characters."
            ];
        }

        // Get existing business information
        $business = $this->businessModel->findById($businessId);

        if (!$business) {
            return [
                "success" => false,
                "message" => "Business not found."
            ];
        }

        // Keep the existing logo if no new file is uploaded
        $logoPath = $business["logo"];

        // Process a new logo if supplied
        if (
            isset($logo["error"]) &&
            $logo["error"] !== UPLOAD_ERR_NO_FILE
        ) {
            if ($logo["error"] !== UPLOAD_ERR_OK) {
                return [
                    "success" => false,
                    "message" => "There was a problem uploading the logo."
                ];
            }

            if ($logo["size"] > 2 * 1024 * 1024) {
                return [
                    "success" => false,
                    "message" => "Logo must not exceed 2 MB."
                ];
            }

            // Check the actual image type
            $imageInfo = @getimagesize($logo["tmp_name"]);

            if ($imageInfo === false) {
                return [
                    "success" => false,
                    "message" => "Please upload a valid image."
                ];
            }

            $allowedTypes = [
                "image/jpeg" => "jpg",
                "image/png" => "png",
                "image/webp" => "webp"
            ];

            $mimeType = $imageInfo["mime"];

            if (!isset($allowedTypes[$mimeType])) {
                return [
                    "success" => false,
                    "message" => "Only JPG, PNG and WebP images are allowed."
                ];
            }

            // Create upload directory if it doesn't exist
            $uploadDirectory = __DIR__ . "/../public/uploads/businesses/";

            if (
                !is_dir($uploadDirectory) &&
                !mkdir($uploadDirectory, 0755, true)
            ) {
                return [
                    "success" => false,
                    "message" => "Unable to create upload directory."
                ];
            }

            // Generate a safe filename
            $fileName = bin2hex(random_bytes(16))
                . "." . $allowedTypes[$mimeType];

            $destination = $uploadDirectory . $fileName;

            if (!move_uploaded_file($logo["tmp_name"], $destination)) {
                return [
                    "success" => false,
                    "message" => "Unable to save uploaded logo."
                ];
            }

            $logoPath = "uploads/businesses/" . $fileName;
        }

        // Save business information
        $updated = $this->businessModel->updateProfile(
            $businessId,
            $businessName,
            $logoPath
        );

        if (!$updated) {
            return [
                "success" => false,
                "message" => "Unable to update business profile."
            ];
        }

        // Remove old logo after successful update
        if (
            !empty($logoPath) &&
            $logoPath !== $business["logo"] &&
            !empty($business["logo"])
        ) {
            $oldLogo = __DIR__ . "/../public/" . $business["logo"];

            if (is_file($oldLogo)) {
                unlink($oldLogo);
            }
        }

        return [
            "success" => true,
            "message" => "Business profile updated successfully."
        ];
    }

    // Display sellers belonging to this business
    public function manageSellers($success = "", $error = "")
    {
        $this->checkBusinessAdmin();

        $businessId = $_SESSION["business_id"];

        $sellers = $this->userModel->getSellersByBusiness($businessId);

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

        if ($this->userModel->findByEmail($email)) {
            return false;
        }

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

    // Display buyers belonging to this business
    public function manageBuyers($success = "", $error = "")
    {
        $this->checkBusinessAdmin();

        $businessId = $_SESSION["business_id"];

        $buyers = $this->userModel->getBuyersByBusiness($businessId);

        require __DIR__ . "/../views/business/buyers.php";
    }

    // Add a new buyer to this business
    public function addBuyer($fullName, $email, $password)
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

        if ($this->userModel->findByEmail($email)) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        return $this->userModel->createBuyerForBusiness(
            $businessId,
            $fullName,
            $email,
            $passwordHash
        );
    }

    // Activate or deactivate a buyer
    public function changeBuyerStatus($buyerId, $status)
    {
        $this->checkBusinessAdmin();

        if (!in_array($status, ["0", "1"], true)) {
            return false;
        }

        $businessId = $_SESSION["business_id"];

        return $this->userModel->updateBuyerStatus(
            $buyerId,
            $businessId,
            (int) $status
        );
    }
}

?>

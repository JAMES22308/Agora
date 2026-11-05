
<?php

require_once __DIR__ . "/../models/Business.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Product.php";

class AdminController
{
    private $businessModel;
    private $userModel;
    private $productModel;

    public function __construct($conn)
    {
        $this->businessModel = new Business($conn);
        $this->userModel = new User($conn);
        $this->productModel = new Product($conn);
    }

    // Check Master Admin access
    private function checkAdmin()
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "agora_admin"
        ) {
            http_response_code(403);
            exit("Access denied.");
        }
    }

    // Display Master Admin dashboard
    public function dashboard()
    {
        $this->checkAdmin();

        $businesses = $this->businessModel->getAll();
        $products = $this->productModel->getAll();

        require __DIR__ . "/../views/dashboard/admin.php";
    }

    // Display all businesses
    public function businesses()
    {
        $this->checkAdmin();

        $businesses = $this->businessModel->getAll();

        require __DIR__ . "/../views/admin/businesses/index.php";
    }

    // Display all users
    public function users()
    {
        $this->checkAdmin();

        // User listing will be added to the User Model next.
        require __DIR__ . "/../views/admin/users/index.php";
    }

    // Display all products
    public function products()
    {
        $this->checkAdmin();

        $products = $this->productModel->getAll();

        require __DIR__ . "/../views/admin/products/index.php";
    }
}

?>

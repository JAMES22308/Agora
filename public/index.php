
<?php

// ==========================================
// START SESSION
// ==========================================

session_start();


// ==========================================
// DATABASE CONNECTION
// ==========================================

require_once __DIR__ . "/../config/database.php";


// ==========================================
// LOAD CONTROLLERS
// ==========================================

require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../controllers/DashboardController.php";
require_once __DIR__ . "/../controllers/BusinessController.php";
require_once __DIR__ . "/../controllers/SellerController.php";
require_once __DIR__ . "/../controllers/BuyerController.php";
require_once __DIR__ . "/../controllers/ProductController.php";
require_once __DIR__ . "/../controllers/AdminController.php";


// ==========================================
// CREATE CONTROLLER OBJECTS
// ==========================================

$authController = new AuthController($conn);
$dashboardController = new DashboardController();
$businessController = new BusinessController($conn);
$sellerController = new SellerController($conn);
$buyerController = new BuyerController($conn);
$productController = new ProductController($conn);
$adminController = new AdminController($conn);


// ==========================================
// GET REQUESTED PAGE
// ==========================================

$page = $_GET["page"] ?? "home";


// ==========================================
// PAGE ROUTING
// ==========================================

switch ($page) {


    // ======================================
    // HOME PAGE
    // ======================================

    case "home":

      

        require __DIR__ . "/../views/home.php";
        break;


    // ======================================
    // LOGIN
    // ======================================

    case "login":

        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = $_POST["email"] ?? "";
            $password = $_POST["password"] ?? "";

            if ($authController->login($email, $password)) {

                header("Location: index.php?page=dashboard");
                exit;

            } else {

                $error = "Invalid email or password.";

            }
        }

        require __DIR__ . "/../views/auth/login.php";
        break;


    // ======================================
    // REGISTER
    // ======================================

    case "register":

        $error = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $fullName = $_POST["full_name"] ?? "";
            $email = $_POST["email"] ?? "";
            $password = $_POST["password"] ?? "";
            $role = $_POST["role"] ?? "";

            if (
                $authController->register(
                    $fullName,
                    $email,
                    $password,
                    $role
                )
            ) {

                $success = "Account created successfully! You can now log in.";

            } else {

                $error = "Registration failed. Check your details or try another email.";

            }
        }

        require __DIR__ . "/../views/auth/register.php";
        break;


    // ======================================
    // DASHBOARD REDIRECTION
    // ======================================

    case "dashboard":

        $dashboardController->index();
        break;


    // ======================================
    // BUSINESS ADMIN
    // ======================================

    case "business-dashboard":

        $businessController->index();
        break;


    // ======================================
    // SELLER
    // ======================================

    case "seller-dashboard":

        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "seller"
        ) {
            header("Location: index.php?page=login");
            exit;
        }

        echo "Seller Dashboard";
        break;


    // ======================================
    // BUYER
    // ======================================

    case "buyer-dashboard":

        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "buyer"
        ) {
            header("Location: index.php?page=login");
            exit;
        }

        echo "Buyer Dashboard";
        break;


    // ======================================
    // AGORA ADMIN
    // ======================================

    case "admin-dashboard":

        $adminController->dashboard();
        break;


    // ======================================
    // LOGOUT
    // ======================================

    case "logout":

        $authController->logout();

        header("Location: index.php?page=login");
        exit;


    // ======================================
    // PAGE NOT FOUND
    // ======================================

    default:

        http_response_code(404);

        echo "Page not found.";
        break;

}

?>

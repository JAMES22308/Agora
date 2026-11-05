
<?php

class DashboardController
{
    // Redirect users to their correct dashboard
    public function index()
    {
        // Check whether the user is logged in
        if (!isset($_SESSION["user_id"])) {

            header("Location: index.php?page=login");
            exit;
        }

        // Get the user's role
        $role = $_SESSION["role"];

        // Redirect according to account role
        switch ($role) {

            case "agora_admin":

                header("Location: index.php?page=admin-dashboard");
                break;

            case "business_admin":

                header("Location: index.php?page=business-dashboard");
                break;

            case "seller":

                header("Location: index.php?page=seller-dashboard");
                break;

            case "buyer":

                header("Location: index.php?page=buyer-dashboard");
                break;

            default:

                header("Location: index.php?page=login");
                break;
        }

        exit;
    }
}

?>


<?php

require_once __DIR__ . "/../models/Order.php";

class OrderController
{
    private $orderModel;

    public function __construct($conn)
    {
        $this->orderModel = new Order($conn);
    }


    // ==========================================
    // PURCHASE PRODUCT
    // ==========================================

    public function purchase()
    {
        if (
            !isset($_SESSION["user_id"]) ||
            ($_SESSION["role"] ?? "") !== "buyer"
        ) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?page=browse-products");
            exit;
        }

        $productId = filter_input(
            INPUT_POST,
            "product_id",
            FILTER_VALIDATE_INT
        );

        $quantity = filter_input(
            INPUT_POST,
            "quantity",
            FILTER_VALIDATE_INT
        );

        if (!$productId || !$quantity || $quantity < 1) {
            header("Location: index.php?page=browse-products");
            exit;
        }

        $result = $this->orderModel->purchase(
            $_SESSION["user_id"],
            $productId,
            $quantity
        );

        if ($result["success"]) {

            header(
                "Location: index.php?page=product-details&id=" .
                $productId . "&purchase=success"
            );

        } else {

            header(
                "Location: index.php?page=product-details&id=" .
                $productId . "&purchase=failed"
            );

        }

        exit;
    }


    // ==========================================
    // DISPLAY BUYER ORDER HISTORY
    // ==========================================

    public function myOrders()
    {
        if (
            !isset($_SESSION["user_id"]) ||
            ($_SESSION["role"] ?? "") !== "buyer"
        ) {
            header("Location: index.php?page=login");
            exit;
        }

        // Get orders belonging to the logged-in buyer
        $orders = $this->orderModel->getByBuyerId(
            $_SESSION["user_id"]
        );

        // Display My Orders page
        require __DIR__ . "/../views/buyer/orders/index.php";
    }
}

?>

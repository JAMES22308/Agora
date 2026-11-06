
<?php

require_once __DIR__ . "/../models/Product.php";

class ProductController
{
    private $productModel;

    public function __construct($conn)
    {
        $this->productModel = new Product($conn);
    }

    // Display all products
    
// Display products for buyers
public function index()
{
    if (
        !isset($_SESSION["user_id"]) ||
        ($_SESSION["role"] ?? "") !== "buyer"
    ) {
        header("Location: index.php?page=login");
        exit;
    }

    $search = trim($_GET["search"] ?? "");

    $products = $this->productModel->getAll($search);

    require __DIR__ . "/../views/buyer/products/index.php";
}


    // Display a seller's products
    public function myProducts()
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "seller"
        ) {
            http_response_code(403);
            exit("Access denied.");
        }

        $products = $this->productModel->getBySellerId(
            $_SESSION["user_id"]
        );

        require __DIR__ . "/../views/seller/products/index.php";
    }

    // Add a product
    public function create($productName, $description, $price, $quantity)
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "seller"
        ) {
            return false;
        }

        if (
            trim($productName) === "" ||
            !is_numeric($price) ||
            $price <= 0 ||
            !filter_var($quantity, FILTER_VALIDATE_INT) ||
            $quantity < 0
        ) {
            return false;
        }

        return $this->productModel->create(
            $_SESSION["user_id"],
            trim($productName),
            trim($description),
            $price,
            $quantity
        );
    }

    // Update a product
    public function update($productId, $productName, $description, $price, $quantity)
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "seller"
        ) {
            return false;
        }

        $product = $this->productModel->findById($productId);

        if (!$product || $product["seller_id"] != $_SESSION["user_id"]) {
            return false;
        }

        if (
            trim($productName) === "" ||
            !is_numeric($price) ||
            $price <= 0 ||
            !filter_var($quantity, FILTER_VALIDATE_INT) ||
            $quantity < 0
        ) {
            return false;
        }

        return $this->productModel->update(
            $productId,
            trim($productName),
            trim($description),
            $price,
            $quantity
        );
    }

    // Delete a product
    public function delete($productId)
    {
        if (
            !isset($_SESSION["user_id"]) ||
            $_SESSION["role"] !== "seller"
        ) {
            return false;
        }

        $product = $this->productModel->findById($productId);

        if (!$product || $product["seller_id"] != $_SESSION["user_id"]) {
            return false;
        }

        return $this->productModel->delete($productId);
    }

    // Display product details for buyers
public function show($productId)
{
    if (
        !isset($_SESSION["user_id"]) ||
        ($_SESSION["role"] ?? "") !== "buyer"
    ) {
        header("Location: index.php?page=login");
        exit;
    }

    $product = $this->productModel->findById($productId);

    if (!$product) {
        header("Location: index.php?page=browse-products");
        exit;
    }

    require __DIR__ . "/../views/buyer/products/show.php";
}
}

?>

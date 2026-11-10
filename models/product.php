
<?php

class Product
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Get all products or search products, including business name
    public function getAll($search = "")
    {
        $sql = "SELECT
                    p.*,
                    b.business_name
                FROM products p
                LEFT JOIN users u
                    ON p.seller_id = u.user_id
                LEFT JOIN businesses b
                    ON u.business_id = b.business_id";

        if ($search !== "") {
            $sql .= " WHERE p.product_name LIKE ?
                      OR p.description LIKE ?
                      OR b.business_name LIKE ?";
        }

        $sql .= " ORDER BY p.product_id DESC";

        $stmt = $this->conn->prepare($sql);

        if ($search !== "") {
            $keyword = "%" . $search . "%";

            $stmt->execute([
                $keyword,
                $keyword,
                $keyword
            ]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find a product using its ID, including business name
    public function findById($productId)
    {
        $sql = "SELECT
                    p.*,
                    b.business_name
                FROM products p
                LEFT JOIN users u
                    ON p.seller_id = u.user_id
                LEFT JOIN businesses b
                    ON u.business_id = b.business_id
                WHERE p.product_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get products belonging to a seller
    public function getBySellerId($sellerId)
    {
        $sql = "SELECT * FROM products WHERE seller_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$sellerId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new product
    public function create($sellerId, $productName, $description, $price, $quantity)
    {
        $sql = "INSERT INTO products
                (seller_id, product_name, description, price, quantity)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $sellerId,
            $productName,
            $description,
            $price,
            $quantity
        ]);
    }

    // Update an existing product
    public function update($productId, $productName, $description, $price, $quantity)
    {
        $sql = "UPDATE products
                SET product_name = ?,
                    description = ?,
                    price = ?,
                    quantity = ?
                WHERE product_id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $productName,
            $description,
            $price,
            $quantity,
            $productId
        ]);
    }

    // Delete a product
    // Delete a product
public function delete($productId)
{
    $sql = "DELETE FROM products WHERE product_id = ?";

    $stmt = $this->conn->prepare($sql);

    try {
        return $stmt->execute([$productId]);
    } catch (PDOException $e) {

        // Product is referenced by an existing order
        if ($e->getCode() === "23000") {
            return false;
        }

        throw $e;
    }
}
}

?>


<?php

class Product
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Get all products
    public function getAll()
    {
        $sql = "SELECT * FROM products ORDER BY product_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find a product using its ID
    public function findById($productId)
    {
        $sql = "SELECT * FROM products WHERE product_id = ?";

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
    public function delete($productId)
    {
        $sql = "DELETE FROM products WHERE product_id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$productId]);
    }
}

?>

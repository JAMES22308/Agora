
<?php

class Order
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Create a new order
    public function create($buyerId)
    {
        $sql = "INSERT INTO orders (buyer_id) VALUES (?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$buyerId]);

        return $this->conn->lastInsertId();
    }

    // Add a product to an order
    public function addItem($orderId, $productId, $quantity)
    {
        $sql = "INSERT INTO order_items
                (order_id, product_id, quantity)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $orderId,
            $productId,
            $quantity
        ]);
    }

    // Get orders belonging to a buyer
    public function getByBuyerId($buyerId)
    {
        $sql = "SELECT * FROM orders
                WHERE buyer_id = ?
                ORDER BY order_date DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$buyerId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get products belonging to an order
    public function getItems($orderId)
    {
        $sql = "SELECT
                    order_items.*,
                    products.product_name,
                    products.price
                FROM order_items
                INNER JOIN products
                    ON order_items.product_id = products.product_id
                WHERE order_items.order_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

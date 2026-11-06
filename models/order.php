
<?php

class Order
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Purchase a product
    public function purchase($buyerId, $productId, $quantity)
    {
        if (
            !filter_var($quantity, FILTER_VALIDATE_INT) ||
            $quantity < 1
        ) {
            return [
                "success" => false,
                "message" => "Please enter a valid quantity."
            ];
        }

        try {

            // Start database transaction
            $this->conn->beginTransaction();

            // Get product and lock its row while purchasing
            $sql = "SELECT product_id, price, quantity
                    FROM products
                    WHERE product_id = ?
                    FOR UPDATE";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productId]);

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                $this->conn->rollBack();

                return [
                    "success" => false,
                    "message" => "Product not found."
                ];
            }

            // Check available stock
            if ((int)$product["quantity"] < $quantity) {
                $this->conn->rollBack();

                return [
                    "success" => false,
                    "message" => "Not enough stock available."
                ];
            }

            // Save the order
            $sql = "INSERT INTO orders (buyer_id)
                    VALUES (?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$buyerId]);

            $orderId = $this->conn->lastInsertId();

            // Save purchased product and original price
            $sql = "INSERT INTO order_items
                    (order_id, product_id, quantity, unit_price)
                    VALUES (?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                $orderId,
                $productId,
                $quantity,
                $product["price"]
            ]);

            // Reduce available stock
            $sql = "UPDATE products
                    SET quantity = quantity - ?
                    WHERE product_id = ?
                    AND quantity >= ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                $quantity,
                $productId,
                $quantity
            ]);

            if ($stmt->rowCount() !== 1) {
                throw new Exception("Unable to update product stock.");
            }

            // Complete transaction
            $this->conn->commit();

            return [
                "success" => true,
                "message" => "Purchase completed successfully.",
                "order_id" => $orderId
            ];

        } catch (Exception $e) {

            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            return [
                "success" => false,
                "message" => "Unable to complete your purchase."
            ];
        }
    }
}

?>

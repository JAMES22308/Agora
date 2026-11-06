
<?php

class Order
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // ==========================================
    // PURCHASE A PRODUCT
    // ==========================================

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

            // Find product and lock its row
            $sql = "SELECT product_id, price, quantity
                    FROM products
                    WHERE product_id = ?
                    FOR UPDATE";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$productId]);

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check whether product exists
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

            // Create new order
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

            // Reduce product stock
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

            // Undo changes if something fails
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            return [
                "success" => false,
                "message" => "Unable to complete your purchase."
            ];
        }
    }


    // ==========================================
    // GET ALL ORDERS BELONGING TO A BUYER
    // ==========================================

    public function getByBuyerId($buyerId)
    {
        $sql = "SELECT
                    orders.order_id,
                    orders.order_date,
                    order_items.product_id,
                    order_items.quantity,
                    order_items.unit_price,
                    products.product_name
                FROM orders

                INNER JOIN order_items
                    ON orders.order_id = order_items.order_id

                INNER JOIN products
                    ON order_items.product_id = products.product_id

                WHERE orders.buyer_id = ?

                ORDER BY
                    orders.order_date DESC,
                    orders.order_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$buyerId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

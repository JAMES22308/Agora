
<?php

require __DIR__ . "/../../layouts/header.php";

// Group products under their respective orders
$groupedOrders = [];

foreach ($orders as $item) {

    $orderId = $item["order_id"];

    if (!isset($groupedOrders[$orderId])) {

        $groupedOrders[$orderId] = [
            "order_id" => $item["order_id"],
            "order_date" => $item["order_date"],
            "items" => [],
            "total" => 0
        ];
    }

    $subtotal = (float)$item["unit_price"] * (int)$item["quantity"];

    $groupedOrders[$orderId]["items"][] = [
        "product_name" => $item["product_name"],
        "quantity" => $item["quantity"],
        "unit_price" => $item["unit_price"],
        "subtotal" => $subtotal
    ];

    $groupedOrders[$orderId]["total"] += $subtotal;
}

?>

<link rel="stylesheet" href="css/buyer/orders.css">

<section class="orders-page">

    <!-- Page Heading -->
    <a href="index.php?page=buyer-dashboard" class="back-button">
        ← Back to Dashboard
    </a>

    <div class="orders-heading">

        <div>
            <h1>My Orders</h1>
            <p>View your purchase history and order details.</p>
        </div>

    </div>


    <!-- Orders Section -->
    <div class="orders-section">

        <div class="orders-section-heading">

            <h2>Purchase History</h2>

            <span>
                <?= count($groupedOrders) ?> order(s) found
            </span>

        </div>


        <?php if (empty($groupedOrders)): ?>

            <!-- Empty State -->
            <div class="empty-orders">

                <div class="empty-icon">
                    <span>📦</span>
                </div>

                <h3>No Orders Yet</h3>

                <p>
                    You haven't purchased any products yet.
                    Browse Agora products to get started.
                </p>

                <a
                    href="index.php?page=browse-products"
                    class="browse-button"
                >
                    Browse Products
                </a>

            </div>

        <?php else: ?>

            <!-- Orders Table -->
            <div class="orders-table-container">

                <table class="orders-table">

                    <thead>

                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Products</th>
                            <th>Quantity</th>
                            <th>Order Total</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($groupedOrders as $order): ?>

                            <tr>

                                <td class="order-id">
                                    #<?= (int)$order["order_id"] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        date(
                                            "d M Y, h:i A",
                                            strtotime($order["order_date"])
                                        )
                                    ) ?>
                                </td>

                                <td>

                                    <div class="order-products">

                                        <?php foreach ($order["items"] as $item): ?>

                                            <div class="order-product">

                                                <strong>
                                                    <?= htmlspecialchars($item["product_name"]) ?>
                                                </strong>

                                                <small>
                                                    $<?= number_format((float)$item["unit_price"], 2) ?>
                                                    each
                                                </small>

                                            </div>

                                        <?php endforeach; ?>

                                    </div>

                                </td>

                                <td>

                                    <?php foreach ($order["items"] as $item): ?>

                                        <div class="order-quantity">
                                            <?= (int)$item["quantity"] ?>
                                        </div>

                                    <?php endforeach; ?>

                                </td>

                                <td class="order-total">
                                    $<?= number_format($order["total"], 2) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</section>

<?php

require __DIR__ . "/../../layouts/footer.php";

?>

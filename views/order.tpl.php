<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>

<!-- Include the partial header -->
@include('partials/header.tpl.php')

<div class="container mt-4">
    <h1>Order Details</h1>

    <!-- Display Order Details -->
    <?php if (!empty($order)): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Order #<?php echo $order['order_id']; ?></h4>
                <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
                <p><strong>Total Price:</strong> £<?php echo number_format($order['total_price'], 2); ?></p>
            </div>
        </div>

        <!-- Display Order Items -->
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($order['order_items'])): ?>
                <?php foreach ($order['order_items'] as $item): ?>
                    <tr>
                        <td><?php echo $item['product_id']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>£<?php echo number_format($item['price'], 2); ?></td>
                        <td>£<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No items found for this order.</td>
                </tr>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong>£<?php echo number_format($order['total_price'], 2); ?></strong></td>
            </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">
            Order not found or it does not contain any items.
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
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
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid d-flex align-items-center">
            <!-- Mobile Toggle Button - Left -->
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Website Logo - Center -->
            <a class="navbar-brand" href="/">Shopping Cart</a>

            <!-- Basket Icon - Right for Mobile -->
            <a href="/basket" class="btn btn-outline-light position-relative d-lg-none" aria-label="Basket">
                <i class="bi bi-basket"></i>
                <!-- Item Count Badge -->
<!--                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-sm-inline d-md-inline d-lg-inline d-sm-inline d-xl-none">-->
<!--                    0-->
<!--                </span>-->
            </a>


            <!-- Collapsible Content: Menu Items, Dropdown, and Search -->
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <!-- Nav Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link" href="/products">Products</a>-->
<!--                    </li>-->
                    <!-- Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink" id="categories-dropdown">
                            <?php foreach ($categories as $menuCategory): ?>
                                <li>
                                    <a class="dropdown-item" href="/category/<?php echo $menuCategory['id'] ?>"><?php echo $menuCategory['name'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                </ul>

                <!-- Search Box -->
                <form class="d-flex" role="search" action="/search" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Search Products" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>

                <!-- Basket Icon -->
                <a href="/basket" class="btn btn-outline-light ms-2 d-none d-lg-inline" aria-label="Basket">
                    <i class="bi bi-basket-fill"></i>
                    <!-- Item Count Badge -->
<!--                    <span class="position-absolute badge rounded-pill bg-danger">-->
<!--                           3-->
<!--                    </span>-->
                </a>

            </div>
        </div>
    </nav>
</header>


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
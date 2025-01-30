<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>

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

    <h1>Your Basket</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <!-- Loop through basket items -->
        <?php foreach ($basketItems as $id => $item): ?>
        <tr>
            <td><?php echo $item['product_name'] ?></td>
            <td><?php echo $item['product_price'] ?></td>
            <td>
                <!-- Decrement Button -->
                <button class="btn btn-sm btn-secondary decrement-quantity" data-product-id="<?php echo $item['product_id'] ?>">-</button>

                <!-- Current Quantity -->
                <span class="quantity-value" id="quantity-<?php echo $item['product_id'] ?>"><?php echo $item['quantity'] ?></span>

                <!-- Increment Button -->
                <button class="btn btn-sm btn-secondary increment-quantity" data-product-id="<?php echo $item['product_id'] ?>">+</button>
            </td>

            <!-- Total price for this product -->
            <td id="total-price-<?php echo $item['product_id'] ?>"><?php echo $item['total_price'] ?></td>
            <td>
                <a href="#" data-product-id="<?php echo $item['product_id'] ?>" class="btn btn-danger btn-sm remove-item">Remove</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Total</td>
            <!-- Overall total for the basket -->
            <td colspan="2" id="basket-total"><?php echo $basketTotal ?></td>
        </tr>
        </tbody>
    </table>
    <a href="/checkout" class="btn btn-success">Checkout</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Ensure Axios is imported or available in your project
    // Example: <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js">

    // Attach event listener to all buttons with class `remove-item`
    document.addEventListener('DOMContentLoaded', () => {
        // Attach event listeners for increment and decrement buttons
        const decrementButtons = document.querySelectorAll('.decrement-quantity');
        const incrementButtons = document.querySelectorAll('.increment-quantity');

        // Add listeners for decrement buttons
        decrementButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const currentQuantity = parseInt(document.getElementById(`quantity-${productId}`).textContent, 10);

                if (currentQuantity > 0) {
                    const newQuantity = currentQuantity - 1;
                    updateQuantity(productId, newQuantity);
                }
            });
        });

        // Add listeners for increment buttons
        incrementButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const currentQuantity = parseInt(document.getElementById(`quantity-${productId}`).textContent, 10);

                const newQuantity = currentQuantity + 1;
                updateQuantity(productId, newQuantity);
            });
        });

        /**
         * Function to send the updated quantity to the server
         * and refresh only the totals.
         */
        function updateQuantity(productId, newQuantity) {
            axios.patch(`/api/v1/basket/update/${productId}`, { quantity: newQuantity }) // Changed to PATCH
                .then(response => {
                    // Response contains the updated basket
                    const updatedBasket = response.data;
                    console.log('Updated basket:', updatedBasket);

                    // Update only the totals in the UI
                    updateTotalsUI(updatedBasket);
                })
                .catch(error => {
                    console.error('Error updating quantity:', error);
                    alert('An error occurred while updating the basket. Please try again.');
                });
        }

        /**
         * Function to update only the totals in the UI.
         */
        function updateTotalsUI(updatedBasket) {
            // Update each item's total price
            updatedBasket.basketItems.forEach(item => {
                // Find the quantity and total price spans and update them
                const quantitySpan = document.getElementById(`quantity-${item.product_id}`);
                const totalPriceCell = document.getElementById(`total-price-${item.product_id}`);

                if (quantitySpan && totalPriceCell) {
                    quantitySpan.textContent = item.quantity;
                    totalPriceCell.textContent = item.total_price;
                }
            });

            // Update the overall basket total
            const basketTotalCell = document.getElementById('basket-total');
            basketTotalCell.textContent = updatedBasket.basketTotal;
        }
    });

</script>
</body>
</html>
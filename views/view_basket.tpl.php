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

@include('partials/header.tpl.php')

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
        @foreach($basketItems as $id => $item)
        <tr>
            <td>{{ $item['product_name'] }}</td>
            <td>{{ $item['product_price'] }}</td>
            <td>
                <!-- Decrement Button -->
                <button class="btn btn-sm btn-secondary decrement-quantity" data-product-id="{{ $item['product_id'] }}">-</button>

                <!-- Current Quantity -->
                <span class="quantity-value" id="quantity-{{ $item['product_id'] }}">{{ $item['quantity'] }}</span>

                <!-- Increment Button -->
                <button class="btn btn-sm btn-secondary increment-quantity" data-product-id="{{ $item['product_id'] }}">+</button>
            </td>

            <!-- Total price for this product -->
            <td id="total-price-{{ $item['product_id'] }}">{{ $item['total_price'] }}</td>
            <td>
                <a href="#" data-product-id="{{ $item['product_id'] }}" class="btn btn-danger btn-sm remove-item">Remove</a>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3">Total</td>
            <!-- Overall total for the basket -->
            <td colspan="2" id="basket-total">{{ $basketTotal }}</td>
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

        // Add event listener for Remove buttons
        const removeButtons = document.querySelectorAll('.remove-item');

        removeButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default link behavior

                const productId = this.getAttribute('data-product-id');

                if (confirm('Are you sure you want to remove this item?')) {
                    removeItemFromBasket(productId);
                }
            });
        });

        /**
         * Function to delete an item from the basket
         * and update the UI accordingly.
         */
        function removeItemFromBasket(productId) {
            axios.delete(`/api/v1/basket/delete/${productId}`) // DELETE request to backend
                .then(response => {
                    const updatedBasket = response.data;
                    console.log('Basket after deletion:', updatedBasket);

                    // Remove the row for the deleted product
                    const productRow = document.querySelector(`tr td .remove-item[data-product-id="${productId}"]`).closest('tr');
                    if (productRow) {
                        productRow.remove();
                    }

                    // Update the basket totals in the UI
                    const basketTotalCell = document.getElementById('basket-total');
                    basketTotalCell.textContent = updatedBasket.basketTotal;

                    if (updatedBasket.basketItems.length === 0) {
                        alert('Your basket is now empty.');
                    }
                })
        }


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
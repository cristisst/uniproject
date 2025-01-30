<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

@include('partials/header.tpl.php')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="/images/nope-not-here.avif" alt="{{ $product['name'] }}" class="img-fluid rounded shadow-sm">
        </div>
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product['name'] }}</h1>
            <h3 class="text-success">£ {{ $product['price'] }}</h3>
            <p class="mt-4">{{ $product['description'] }}</p>
            <div class="mt-4">
                <!-- Add to Basket Button -->
                <a href="" data-product-id="{{ $product['id'] }}" class="btn btn-success">Add to Basket</a>
                <!-- Back to Products Button -->
                <a href="/products" class="btn btn-secondary btn-lg">Back to Products</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const showSuccessModal = () => {
            // Create the modal structure
            const modalHtml = `
                <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel">Success</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Product successfully added to the basket!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                                <button type="button" class="btn btn-primary" id="viewBasketButton">View Basket</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Append modal to the body
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            const successModal = new bootstrap.Modal(document.getElementById('successModal'), {
                keyboard: true
            });
            successModal.show();

            // Add an event listener to the "View Basket" button
            document.getElementById('viewBasketButton').addEventListener('click', () => {
                window.location.href = '/basket'; // Redirects to the basket page
            });

            // Cleanup modal after it's hidden
            document.getElementById('successModal').addEventListener('hidden.bs.modal', () => {
                document.getElementById('successModal').remove();
            });
        };

        // Event delegation for "Add to Basket" buttons
        document.addEventListener('click', async (event) => {
            const target = event.target;

            if (target.classList.contains('btn-success')) {
                event.preventDefault(); // Prevent default link behavior

                // Get the product ID from the data attribute
                const productId = target.getAttribute('data-product-id');

                // Make a POST request to add the product to the basket
                try {
                    const response = await axios.post('/api/v1/basket/add', {
                        product_id: productId // Send product ID in the payload
                    });

                    // If the request is successful, show the modal
                    if (response.status === 200) {
                        // alert('Successfully added the product to the basket.');
                        showSuccessModal();
                    }
                } catch (error) {
                    // Handle errors (e.g., show an error message to the user)
                    console.error('Error adding product to basket:', error);
                    alert('Failed to add the product to the basket. Please try again.');
                }
            }

        });
    })
</script>
</body>
</html>
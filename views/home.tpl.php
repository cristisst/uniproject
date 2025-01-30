<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - {{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>

@include('partials/header.tpl.php')

<div class="container mt-4">
    <h1>{{ $heading }}</h1>
    <p>Shop the best products across multiple categories!</p>

    <!-- Section 1: Featured Products -->
    <div class="mt-5">
        <h2>Featured Products</h2>
        <div id="featured-products" class="scrollable-section">
            <!-- Dynamic products will be inserted here -->
        </div>

    </div>

    <!-- Section 2: New Arrivals -->
    <div class="mt-5">
        <h2>New Arrivals</h2>
        <div class="scrollable-section" id="new-arrivals">
            <!-- Dynamic products will be inserted here -->
        </div>
    </div>
</div>

<div id="categories-container">
    <!-- Categories will be dynamically inserted here -->
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Include the categories.js file -->
<script>
    // Fetch categories using Axios
    document.addEventListener('DOMContentLoaded', () => {

        const featuredProductsContainer = document.getElementById('featured-products');
        const newArrivalsProductsContainer = document.getElementById('new-arrivals');
        const fetchProducts = async (endpoint, container) => {
            try {
                const response = await axios.get(endpoint);
                if (response.status === 200 && response.data) {
                    response.data.forEach(product => {
                        const productBox = `
                            <div class="product-box">
                                <img src="${product.image}" alt="${product.name}">
                                <h5>${product.name}</h5>
                                <p>£${product.price}</p>
                                <a href="/product/${product.id}" class="btn btn-primary">View Details</a>
                            </div>
                        `;
                        container.innerHTML += productBox;
                    });
                }
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        };

        fetchProducts('/api/v1/products/featured', featuredProductsContainer);
        fetchProducts('/api/v1/products/?sort=Newest', newArrivalsProductsContainer);
    });
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>

@include('partials/header.tpl.php')

<div class="container mt-4">
    <h1>Search Results</h1>
    <div class="d-flex align-items-center justify-content-between">
        <p>Results for: "{{ $query }}"</p>

        <!-- Filter Toggle Button -->
        <button type="button" id="toggle-filter" class="btn btn-outline-primary">Filter</button>
    </div>

    <!-- Hidden Filter Box -->
    <div class="filters p-3 border rounded mt-3 d-none" id="filter-box">
        <h5>Filter By:</h5>
        <form id="filter-form">
            <!-- Category Filter -->
            <div class="mb-3">
                <label for="category-filter" class="form-label">Category:</label>
                <select id="category-filter" class="form-select">
                    <option value="" selected>All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Price Range -->
            <div class="mb-3">
                <label for="price-range" class="form-label">Price Range (min-max):</label>
                <input type="range" id="price-range" class="form-range" min="0" max="1000" step="10">
                <div class="d-flex justify-content-between">
                    <span id="price-min">£0</span>
                    <span id="price-max">£1000</span>
                </div>
            </div>
            <button type="button" class="btn btn-primary w-100" id="apply-filter">Apply Filters</button>
        </form>
    </div>

    <!-- Loading Spinner -->
    <div class="text-center my-4 d-none" id="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="row" id="products-container">
        @if(count($products) === 0)
        <div class="col-12 text-center">
            <p class="text-muted">No products found matching your search.</p>
        </div>
        @else
            <!-- Loop through search results -->
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="/images/nope-not-here.avif" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product['name'] }}</h5>
                        <p class="card-text">£ {{ $product['price'] }}</p>
                        <a href="/product/{{ $product['id'] }}" class="btn btn-info">Details</a>
                        <a href="/basket/add/{{ $product['id'] }}" data-product-id="{{ $product['id'] }}" class="btn btn-success">Add to Basket</a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Include the categories.js file -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const categoryFilter = document.getElementById('category-filter');
        const priceRange = document.getElementById('price-range');
        const priceMin = document.getElementById('price-min');
        const priceMax = document.getElementById('price-max');
        const applyFilterButton = document.getElementById('apply-filter');
        const filterBox = document.getElementById('filter-box');
        const toggleFilterButton = document.getElementById('toggle-filter');
        const loadingSpinner = document.getElementById('loading-spinner'); // Spinner Element
        const productsContainer = document.getElementById('products-container'); // Products container

        // Show/Hide Filter Box
        toggleFilterButton.addEventListener('click', () => {
            filterBox.classList.toggle('d-none');
        });

        // Update price labels when the range slider changes
        priceRange.addEventListener('input', (e) => {
            const value = e.target.value;
            priceMin.textContent = '£0';
            priceMax.textContent = `£${value}`;
        });

        // Handle filter application
        applyFilterButton.addEventListener('click', () => {
            filterBox.classList.toggle('d-none');
            const selectedCategory = categoryFilter.value;
            const maxPrice = priceRange.value;

            // Show the loading spinner
            loadingSpinner.classList.remove('d-none');
            productsContainer.style.visibility = 'hidden'; // Hide products while loading

            // Build the filter query
            let query = `/api/v1/products/search?query={{ $query }}`;
            if (selectedCategory) {
                query += `&category=${selectedCategory}`;
            }
            query += `&max_price=${maxPrice}`;

            // Update search results using Axios
            axios.get(query)
                .then(response => {
                    const productsContainer = document.querySelector('.row');
                    const products = response.data.products;

                    let html = '';

                    if (products.length > 0) {
                        products.forEach(product => {
                            html += `
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="/images/nope-not-here.avif" class="card-img-top" alt="Product Image">
                                    <div class="card-body">
                                        <h5 class="card-title">${product.name}</h5>
                                        <p class="card-text">£ ${product.price}</p>
                                        <a href="/product/${product.id}" class="btn btn-info">Details</a>
                                        <a href="/basket/add/${product.id}" data-product-id="${product.id}" class="btn btn-success">Add to Basket</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        });
                    } else {
                        html = `
                        <div class="col-12 text-center">
                            <p class="text-muted">No products found matching your filters.</p>
                        </div>
                    `;
                    }

                    // Inject the filtered products into the DOM
                    productsContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching filtered results:', error);
                })
                .finally(() => {
                    // Hide the spinner and show the products
                    loadingSpinner.classList.add('d-none');
                    productsContainer.style.visibility = 'visible';
                });

        });

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
    });
</script>
</body>
</html>

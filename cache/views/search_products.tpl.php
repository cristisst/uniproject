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
    <h1>Search Results</h1>
    <div class="d-flex align-items-center justify-content-between">
        <p>Results for: "<?php echo $query ?>"</p>

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
                    <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                    <?php endforeach; ?>
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
        <?php if (count($products) === 0): ?>
        <div class="col-12 text-center">
            <p class="text-muted">No products found matching your search.</p>
        </div>
        <?php else: ?>
            <!-- Loop through search results -->
            <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="/images/nope-not-here.avif" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name'] ?></h5>
                        <p class="card-text">£ <?php echo $product['price'] ?></p>
                        <a href="/product/<?php echo $product['id'] ?>" class="btn btn-info">Details</a>
                        <a href="/basket/add/<?php echo $product['id'] ?>" class="btn btn-success">Add to Basket</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
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
            let query = `/api/v1/products/search?query=<?php echo $query ?>`;
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
                                        <a href="/basket/add/${product.id}" class="btn btn-success">Add to Basket</a>
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

        // Event delegation for "Add to Basket" buttons
        document.addEventListener('click', (event) => {
            const target = event.target;

            if (target.classList.contains('btn-success')) {
                event.preventDefault(); // Prevent default link behavior

                // Get the URL of the clicked button
                const productUrl = target.getAttribute('href');

                // Example action: Log or send request (replace with your functionality)
                console.log(`Adding product to basket from URL: ${productUrl}`);

                // Example: Display confirmation (replace or extend with real implementation)
                alert('Product added to the basket!');
            }
        });
    });
</script>
</body>
</html>

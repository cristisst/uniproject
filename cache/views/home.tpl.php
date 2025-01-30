<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - <?php echo $title ?></title>
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
    <h1><?php echo $heading ?></h1>
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
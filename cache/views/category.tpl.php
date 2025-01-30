<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Categories</title>
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
    <h1 id="name" data-id="<?php echo $category['id'] ?>">Category: <?php echo $category['name'] ?></h1>
    <!-- Sorting Dropdown (Initially Hidden) -->
    <div class="mb-3 row" id="sort-box">
        <div class="col-md-4 col-sm-6">
            <label for="sort-select" class="form-label">Sort By:</label>
            <select id="sort-select" class="form-select">
                <option value="newest" selected>Newest</option>
                <option value="oldest">Oldest</option>
                <option value="a-to-z">A to Z</option>
                <option value="z-to-a">Z to A</option>
                <option value="price-low-to-high">Price: Low to High</option>
                <option value="price-high-to-low">Price: High to Low</option>
            </select>
        </div>
    </div>

    <!-- Loading Spinner Placeholder -->
    <div id="loading-spinner" class="text-center my-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Content Placeholder -->
    <div id="category-content" class="d-none row"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Include the categories.js file -->
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const spinner = document.getElementById('loading-spinner');
        const content = document.getElementById('category-content');
        const sortBox = document.getElementById('sort-box');
        const sortSelect = document.getElementById('sort-select');
        const categoryId = document.getElementById('name').getAttribute('data-id');

        // Function to fetch data from the API with an optional sort parameter
        const fetchProducts = async (sort = 'newest') => {
            try {
                spinner.style.display = 'block'; // Show spinner while fetching
                content.classList.add('d-none'); // Hide content during fetch

                // Fetch products with the selected sort query parameter
                const response = await axios.get(`/api/v1/category/${categoryId}?sort=${sort}`);
                const products = response.data || [];
                displayProducts(products);
            } catch (error) {
                console.error('Error fetching category data:', error);

                // Handle fetch error
                content.innerHTML = `
                <div class="col-12 text-danger text-center">
                    <p>Failed to load category content. Please try again later.</p>
                </div>
            `;
            } finally {
                spinner.style.display = 'none'; // Hide spinner when done
                content.classList.remove('d-none'); // Show content
                sortBox.classList.remove('d-none'); // Ensure sort box is always visible after first load
            }
        };

        // Function to display fetched products in the category content div
        const displayProducts = (products) => {
            let html = ``;

            if (products.length > 0) {
                products.forEach(product => {
                    html += `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="${product.image}" class="card-img-top" alt="${product.name}">
                            <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">${product.description}</p>
                                <p class="card-text fw-bold">£${product.price}</p>
                                <a href="/product/${product.id}" class="btn btn-primary">View Details</a>
                                <a href="" data-product-id="${product.id}" class="btn btn-success">Add to Basket</a>
                            </div>
                        </div>
                    </div>
                `;
                });
            } else {
                html += `
                <div class="col-12">
                    <p>No products found in this category.</p>
                </div>
            `;
            }

            // Insert products into the category content div
            content.innerHTML = html;
        };

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

        // Event listener for sort dropdown
        sortSelect.addEventListener('change', (e) => {
            const selectedSort = e.target.value; // Get the selected sort option
            fetchProducts(selectedSort); // Fetch products with the selected sort
        });

        // Initial data load (fetch products with default sorting)
        await fetchProducts();

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
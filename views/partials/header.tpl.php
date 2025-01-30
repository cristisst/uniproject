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
                            @foreach($categories as $menuCategory)
                                <li>
                                    <a class="dropdown-item" href="/category/{{ $menuCategory['id'] }}">{{ $menuCategory['name'] }}</a>
                                </li>
                            @endforeach
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

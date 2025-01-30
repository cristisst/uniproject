<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>

@include('partials/header.tpl.php')

<div class="container mt-4">
    <h1>Products</h1>
    <div class="row">
        <!-- Loop through products -->
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="/images/nope-not-here.avif" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product['name'] }}</h5>
                        <p class="card-text">£ {{ $product['price'] }}</p>
                        <a href="/product/{{ $product['id'] }}" class="btn btn-info">Details</a>
                        <a href="/basket/add/{{ $product['id'] }}" class="btn btn-success">Add to Basket</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@include('partials/header.tpl.php')

<div class="container mt-4">
    <h1>Categories</h1>
    <div class="row">
        <div class="col-md-3 mb-3">
            <a href="/products?category=electronics" class="btn btn-primary btn-block">Electronics</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/products?category=fashion" class="btn btn-primary btn-block">Fashion</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/products?category=home" class="btn btn-primary btn-block">Home</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/products?category=books" class="btn btn-primary btn-block">Books</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</body>
</html>
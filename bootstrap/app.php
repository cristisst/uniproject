<?php

use App\Controllers\Web\BasketController;
use App\Controllers\Web\CategoryController;
use App\Controllers\Web\HomeController;
use App\Controllers\Web\OrderController;
use App\Controllers\Web\ProductController;
use App\Core\Http\Routing\Router;

$app = new App\Core\Application(
    dirname(__DIR__)
);

$app->set('router', function () use ($app) {
    $router = new Router();

    $router->enableCaching(true);
    $router->setCacheFile($app->getBasePath() . '/cache/routes_cache.php');

    //Web Routes
    $router->addRoute('GET', '/', HomeController::class, 'index');
    $router->addRoute('GET', '/search', ProductController::class, 'search');
    $router->addRoute('GET', '/product/{id}', ProductController::class, 'show');
    $router->addRoute('GET', '/category/{id}', CategoryController::class, 'show');
    //basket routes
    $router->addRoute('GET', '/basket', BasketController::class, 'viewBasket');
    $router->addRoute('GET', '/basket/add/{productId}', BasketController::class, 'addProduct');
    $router->addRoute('GET', '/basket/remove/{productId}', BasketController::class, 'removeProduct');
    $router->addRoute('GET', '/checkout', OrderController::class, 'create');

    //API Routes
    $router->addRoute('GET', '/api/v1/categories', 'App\Controllers\Api\CategoryController', 'index');
    $router->addRoute('GET', '/api/v1/category/{id}', 'App\Controllers\Api\CategoryController', 'products');
    $router->addRoute('GET', '/api/v1/products/featured', 'App\Controllers\Api\ProductController', 'featured');
    $router->addRoute('GET', '/api/v1/products/', 'App\Controllers\Api\ProductController', 'index');
    $router->addRoute('GET', '/api/v1/products/search', 'App\Controllers\Api\ProductController', 'search');
    $router->addRoute('POST','/api/v1/basket/add', 'App\Controllers\Api\BasketController', 'addProduct');
    $router->addRoute('DELETE','/api/v1/basket/delete/{productId}', 'App\Controllers\Api\BasketController', 'deleteProduct');
    $router->addRoute('PATCH', '/api/v1/basket/update/{productId}', 'App\Controllers\Api\BasketController', 'updateProduct');
    return $router;
});

return $app;

<?php return array (
  0 => 
  array (
    'method' => 'GET',
    'path' => '/',
    'controller' => 'App\\Controllers\\Web\\HomeController',
    'action' => 'index',
  ),
  1 => 
  array (
    'method' => 'GET',
    'path' => '/products',
    'controller' => 'App\\Controllers\\Web\\ProductController',
    'action' => 'index',
  ),
  2 => 
  array (
    'method' => 'GET',
    'path' => '/search',
    'controller' => 'App\\Controllers\\Web\\ProductController',
    'action' => 'search',
  ),
  3 => 
  array (
    'method' => 'GET',
    'path' => '/product/{id}',
    'controller' => 'App\\Controllers\\Web\\ProductController',
    'action' => 'show',
  ),
  4 => 
  array (
    'method' => 'GET',
    'path' => '/basket',
    'controller' => 'App\\Controllers\\Web\\BasketController',
    'action' => 'viewBasket',
  ),
  5 => 
  array (
    'method' => 'GET',
    'path' => '/basket/add/{productId}',
    'controller' => 'App\\Controllers\\Web\\BasketController',
    'action' => 'addProduct',
  ),
  6 => 
  array (
    'method' => 'GET',
    'path' => '/basket/remove/{productId}',
    'controller' => 'App\\Controllers\\Web\\BasketController',
    'action' => 'removeProduct',
  ),
  7 => 
  array (
    'method' => 'GET',
    'path' => '/checkout',
    'controller' => 'App\\Controllers\\Web\\BasketController',
    'action' => 'checkout',
  ),
  8 => 
  array (
    'method' => 'GET',
    'path' => '/api/v1/categories',
    'controller' => 'App\\Controllers\\Api\\CategoryController',
    'action' => 'index',
  ),
  9 => 
  array (
    'method' => 'GET',
    'path' => '/api/v1/products/featured',
    'controller' => 'App\\Controllers\\Api\\ProductController',
    'action' => 'featured',
  ),
);
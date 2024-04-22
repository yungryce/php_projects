<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\AuthController;
use App\Controllers\Api\UserController;
use App\Filters\AuthFilter;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->group('', function($routes) {
    $routes->post('register', [AuthController::class, 'register']);
    $routes->post('login', [AuthController::class, 'login']);
    $routes->post('logout', [AuthController::class, 'logout'], ['filter' => AuthFilter::class]);
});

$routes->group('api', ['filter' => AuthFilter::class], function($routes) {

    $routes->get('user/(:num)', [UserController::class, 'index/$1']);
    $routes->post('user/(:num)/kyc', [UserController::class, 'submitKYC/$1']);
    $routes->put('user/(:num)/kyc/(:num)', [UserController::class, 'updateKYC/$1/$2']);
});





$routes->group('categories', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'CategoryController::index');  // View all categories
    $routes->get('(:num)', 'CategoryController::show/$1');  // View specific category
    $routes->post('create', 'CategoryController::create');  // Create new category
    $routes->put('update/(:num)', 'CategoryController::update/$1');  // Update existing category
    $routes->delete('delete/(:num)', 'CategoryController::delete/$1');  // Delete category
});


$routes->group('products', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'ProductController::index');  // View all products
    $routes->get('(:num)', 'ProductController::show/$1');  // View specific product
    $routes->post('create', 'ProductController::create');  // Create new product
    $routes->put('update/(:num)', 'ProductController::update/$1');  // Update existing product
    $routes->delete('delete/(:num)', 'ProductController::delete/$1');  // Delete product
});

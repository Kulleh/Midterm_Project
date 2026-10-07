<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Login::index');

$routes->get('login', 'Login::index');
$routes->post('login', 'Login::submit');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->post('logout', 'Login::logout');

    $routes->get('products', 'Products::index');
    $routes->get('products/create', 'Products::create');
    $routes->post('products/store', 'Products::store');
    $routes->get('products/edit/(:num)', 'Products::edit/$1');
    $routes->post('products/update/(:num)', 'Products::update/$1');
    $routes->get('products/delete/(:num)', 'Products::delete/$1');

    $routes->get('customers', 'Customers::index');
    $routes->get('customers/create', 'Customers::create');
    $routes->post('customers/store', 'Customers::store');
    $routes->get('customers/edit/(:num)', 'Customers::edit/$1');
    $routes->post('customers/update/(:num)', 'Customers::update/$1');
    $routes->get('customers/delete/(:num)', 'Customers::delete/$1');

    $routes->get('users', 'Users::index');
    $routes->get('users/create', 'Users::create');
    $routes->post('users/store', 'Users::store');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
    $routes->get('users/delete/(:num)', 'Users::delete/$1');

    $routes->get('sales/create', 'Sales::create');
    $routes->post('sales/store', 'Sales::store');
    $routes->get('sales/history', 'Sales::history');
});

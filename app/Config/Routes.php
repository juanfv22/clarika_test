<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api/guests', ['namespace' => 'App\controllers\API'], function($routes) {
    $routes->get('/', 'Guests::index');
    $routes->post('/', 'Guests::create');
    $routes->get('(:num)', 'Guests::show/$1');
    $routes->put('(:num)', 'Guests::update/$1');
    $routes->delete('(:num)', 'Guests::delete/$1');
});

$routes->group('guests', function($routes) {
    $routes->get('/', 'Guests::index'); 
    $routes->get('create', 'Guests::create');
    $routes->post('store', 'Guests::store');
    $routes->get('edit/(:num)', 'Guests::edit/$1');
    $routes->post('update/(:num)', 'Guests::update/$1');
    $routes->get('delete/(:num)', 'Guests::delete/$1');
});

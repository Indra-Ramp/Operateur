<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('operateur', function($routes) {
    $routes->get('prefix', 'PrefixeController::list');
    $routes->post('prefix/new', 'PrefixeController::addPrefix');
    $routes->get('choose-operation', 'FraisController::listOperation');
    $routes->get('list-fees/(:num)', 'FraisController::list/$1');
    $routes->post('fee/add', 'FraisController::addFee');
    $routes->post('fee/update', 'FraisController::updateFee');
});

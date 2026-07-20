<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('operateur', function($routes) {
    $routes->get('prefix', 'PrefixeController::list');
    $routes->post('prefix/new', 'PrefixeController::addPrefix');
});

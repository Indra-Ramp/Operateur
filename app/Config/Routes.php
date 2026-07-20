<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->group('client', function($routes){
    $routes->get('login', 'AuthController::index');
    $routes->post('dashboard', 'AuthController::dashboard');
    $routes->get('dashboard', 'AuthController::dashboard');
    $routes->get('transactions', 'OperationController::transactions');
    $routes->post('depot', 'OperationController::depot');
    $routes->post('retrait', 'OperationController::retrait');
    $routes->post('transfert', 'OperationController::transfert');
});
$routes->get('/', 'AuthController::index');
$routes->group('operateur', function($routes) {
    $routes->get('prefix', 'PrefixeController::list');
    $routes->post('prefix/new', 'PrefixeController::addPrefix');
    $routes->get('choose-operation', 'FraisController::listOperation');
    $routes->get('list-fees/(:num)', 'FraisController::list/$1');
    $routes->post('fee/add', 'FraisController::addFee');
    $routes->post('fee/update', 'FraisController::updateFee');
});

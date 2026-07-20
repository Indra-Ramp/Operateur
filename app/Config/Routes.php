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

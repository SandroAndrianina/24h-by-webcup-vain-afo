<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

// Auth
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');

$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register');

$routes->get('/register-agent', 'AuthController::registerAgent');
$routes->post('/register-agent', 'AuthController::registerAgent');

$routes->get('/logout', 'AuthController::logout');

// Dashboards
$routes->get('/admin', 'AdminController::index', ['filter' => 'admin']);
$routes->get('/agent', 'AgentController::index', ['filter' => 'agent']);
$routes->get('/citoyen', 'CitoyenController::index', ['filter' => 'auth']);






$routes->get('/citoyen', 'CitoyenController::index', ['filter' => 'auth']);
// === Citoyen — Mes demandes (D11 + F26) ===
$routes->group('citoyen', ['filter' => 'auth'], static function ($routes) {
    $routes->get('requests',         'CitoyenController::requests');
    $routes->get('requests/new',     'CitoyenController::newRequest');
    $routes->post('requests',        'CitoyenController::createRequest');
    $routes->get('requests/(:num)',  'CitoyenController::showRequest/$1');
    
});



// === Services (D05) ===
$routes->addRedirect('menu', 'services');
$routes->get('services',        'ServiceController::index',   ['filter' => 'auth']);
$routes->get('services/(:num)', 'ServiceController::show/$1', ['filter' => 'auth']);
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



$routes->group('citoyen', ['filter' => 'auth'], static function ($routes) {
    $routes->get('requests',        'Citizen\RequestController::index');
    $routes->get('requests/new',    'Citizen\RequestController::create');
    $routes->post('requests',       'Citizen\RequestController::store');
    $routes->get('requests/(:num)', 'Citizen\RequestController::show/$1');

    $routes->get('contact',         'Citizen\ContactController::create');
    $routes->post('contact',        'Citizen\ContactController::store');

    $routes->get('profile',         'Citizen\ProfileController::show');
    $routes->post('profile',        'Citizen\ProfileController::update');
});
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
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::attempt');
$routes->get('dashboard', 'DashboardAdmin::index');
$routes->get('admin/dashboard', 'DashboardAdmin::index');
$routes->get('menu', 'Menu::index');

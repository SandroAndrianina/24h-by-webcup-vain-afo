<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

// Auth
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// Dashboards
$routes->get('/admin', 'AdminController::index');
$routes->get('/agent', 'AgentController::index');
$routes->get('/citoyen', 'CitoyenController::index');
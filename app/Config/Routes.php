<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ===== Modules =====
require APPPATH . 'Modules/Requests/Http/Routes.php';

// ===== Intro & Home =====
$routes->get('/',    'Home::index');
$routes->get('menu', 'Menu::index');

// ===== Auth (NE PAS TOUCHER) =====
$routes->get('login',           'AuthController::index');
$routes->post('login',          'AuthController::login');
$routes->get('register',        'AuthController::register');
$routes->post('register',       'AuthController::register');
$routes->get('register-agent',  'AuthController::registerAgent');
$routes->post('register-agent', 'AuthController::registerAgent');
$routes->get('logout',          'AuthController::logout');

// ===== Dashboards =====
$routes->get('citoyen', 'CitoyenController::index', ['filter' => 'auth']);
$routes->get('agent',   'AgentController::index',   ['filter' => 'agent']);

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/',                  'AdminController::index');
    $routes->get('dashboard',          'AdminController::dashboard');
    $routes->get('users',              'AdminController::users');
    $routes->post('users/(:num)/role', 'AdminController::updateRole/$1');
});

// ===== Public =====
$routes->get('announcements',         'Announcements::index');
$routes->get('announcements/(:num)',  'Announcements::show/$1');
$routes->get('services/(:num)',       'Service::show/$1');
$routes->get('lang/(:segment)',       'Locale::switch/$1');
$routes->get('menu/regen-alert',      'Menu::regenAlert');
$routes->get('prewarm/(:segment)',    'Prewarm::index/$1');
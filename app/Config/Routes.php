<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::attempt');
$routes->get('dashboard', 'DashboardAdmin::index');
$routes->get('admin/dashboard', 'DashboardAdmin::index');
$routes->get('/', 'Menu::index');

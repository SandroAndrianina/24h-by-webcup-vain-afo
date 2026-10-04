<?php

$routes->group('citoyen/requests', [
    'filter'    => 'auth',
    'namespace' => 'Modules\Requests\Http\Controllers',
], function ($routes) {
    $routes->get('/',      'CitizenRequestController::index');
    $routes->get('new',    'CitizenRequestController::new');
    $routes->post('/',     'CitizenRequestController::store');
    $routes->get('(:num)', 'CitizenRequestController::show/$1');
});

$routes->group('citoyen/contact', [
    'filter'    => 'auth',
    'namespace' => 'Modules\Requests\Http\Controllers',
], function ($routes) {
    $routes->get('/',  'CitizenContactController::new');
    $routes->post('/', 'CitizenContactController::store');
});
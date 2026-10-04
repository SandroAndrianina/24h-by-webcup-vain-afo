<?php
$routes->group('citoyen', ['filter' => 'auth'], static function ($routes) {
    $routes->get('requests',         'Requests\CitizenRequestController::index');
    $routes->get('requests/new',     'Requests\CitizenRequestController::create');
    $routes->post('requests',        'Requests\CitizenRequestController::store');
    $routes->get('requests/(:num)',  'Requests\CitizenRequestController::show/$1');
});
<?php
require APPPATH . 'Modules/Requests/Http/Routes.php';
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ===== Intro & Home =====
$routes->get('/',      'Home::index');   // vidéo loader (1ère visite)
$routes->get('menu',   'Menu::index');   // page services (vitrine)

// ===== Auth (NE PAS TOUCHER) =====
$routes->get('login',           'AuthController::index');
$routes->post('login',          'AuthController::login');
$routes->get('register',        'AuthController::register');
$routes->post('register',       'AuthController::register');
$routes->get('register-agent',  'AuthController::registerAgent');
$routes->post('register-agent', 'AuthController::registerAgent');
$routes->get('logout',          'AuthController::logout');

// ===== Dashboards =====
$routes->get('admin',           'AdminController::index',   ['filter' => 'admin']);
$routes->get('agent',           'AgentController::index',   ['filter' => 'agent']);
$routes->get('agent/dashboard', 'AgentController::index', ['filter' => 'agent']);
$routes->get('citoyen',         'CitoyenController::index', ['filter' => 'auth']);

// ===== Agent - demandes =====
$routes->get('agent/requests', 'AgentRequestController::index', ['filter' => 'agent']);
$routes->get('agent/requests/(:num)', 'AgentRequestController::show/$1', ['filter' => 'agent']);
$routes->post('agent/requests/(:num)/status', 'AgentRequestController::updateStatus/$1', ['filter' => 'agent']);

// ===== Agent - annonces =====
$routes->get('agent/announcements', 'AgentAnnouncementController::index', ['filter' => 'agent']);
$routes->get('agent/announcements/new', 'AgentAnnouncementController::new', ['filter' => 'agent']);
$routes->post('agent/announcements/create', 'AgentAnnouncementController::create', ['filter' => 'agent']);

// ===== Agent - messages =====
$routes->get('agent/messages', 'AgentMessageController::index', ['filter' => 'agent']);
$routes->get('agent/messages/(:num)', 'AgentMessageController::show/$1', ['filter' => 'agent']);

$routes->get('admin/dashboard', 'DashboardAdmin::index');

$routes->get('announcements',      'Announcements::index');
$routes->get('announcements/(:num)', 'Announcements::show/$1');

$routes->get('services/(:num)', 'Service::show/$1');

$routes->get('lang/(:segment)', 'Locale::switch/$1');

$routes->get('menu/regen-alert', 'Menu::regenAlert');

$routes->get('prewarm/(:segment)', 'Prewarm::index/$1');
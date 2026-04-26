<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

// Account routes
$routes->get('account/password', 'AccountController::change', ['filter' => 'auth']);
$routes->post('account/password', 'AccountController::update', ['filter' => 'auth']);

$routes->group('users', ['filter' => ['auth', 'role:super_admin']], static function ($routes) {
	$routes->get('/', 'UsersController::index');
	$routes->get('create', 'UsersController::create');
	$routes->post('store', 'UsersController::store');
	$routes->get('edit/(:num)', 'UsersController::edit/$1');
	$routes->post('update/(:num)', 'UsersController::update/$1');
	$routes->post('delete/(:num)', 'UsersController::delete/$1');
});

$routes->group('clients', ['filter' => 'auth'], static function ($routes) {
	$routes->get('/', 'ClientsController::index');

	$routes->get('create', 'ClientsController::create', ['filter' => 'role:super_admin']);
	$routes->post('store', 'ClientsController::store', ['filter' => 'role:super_admin']);
	$routes->get('edit/(:num)', 'ClientsController::edit/$1', ['filter' => 'role:super_admin']);
	$routes->post('update/(:num)', 'ClientsController::update/$1', ['filter' => 'role:super_admin']);
	$routes->post('load/(:num)', 'ClientsController::loadForEdit/$1', ['filter' => 'role:super_admin']);
	$routes->post('delete/(:num)', 'ClientsController::delete/$1', ['filter' => 'role:super_admin']);

	$routes->get('view/(:num)', 'ClientsController::view/$1', ['filter' => 'clientAccess']);
	$routes->post('view/(:num)/decrypt', 'ClientsController::decrypt/$1', ['filter' => 'clientAccess']);
});

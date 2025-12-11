<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home/testDB', 'Home::testDB');
// rutas de auth
$routes->get('/login', 'Auth::login');
$routes->post('/loginPost', 'Auth::loginPost');
$routes->get('/logout', 'Auth::logout');

// dashboard protegido por filtro 'auth'
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// rutas de ejemplo para admin (puedes implementarlas después)
$routes->group('admin', ['filter' => 'auth'], function($routes){
    $routes->get('salas', 'Admin\Rooms::index');
});

// rutas de reservas (para todos los usuarios autenticados)
$routes->get('reservas', 'Reservas::index', ['filter' => 'auth']);
$routes->get('reservas/new', 'Reservations::create', ['filter' => 'auth']);




// SALAS
$routes->get('salas', 'Salas::index', ['filter' => 'auth']);       // lista
$routes->get('salas/crear', 'Salas::create', ['filter' => 'auth']);
$routes->post('salas/guardar', 'Salas::store', ['filter' => 'auth']);
$routes->get('salas/editar/(:num)', 'Salas::edit/$1', ['filter' => 'auth']);
$routes->post('salas/actualizar', 'Salas::update', ['filter' => 'auth']);

// RESERVAS
$routes->get('reservas/crear', 'Reservas::create', ['filter' => 'auth']);
$routes->post('reservas/guardar', 'Reservas::store', ['filter' => 'auth']);
$routes->get('reservas/calendar', 'Reservas::calendar', ['filter' => 'auth']);
$routes->get('reservas/events', 'Reservas::events', ['filter' => 'auth']); // JSON para FullCalendar


$routes->get('/visitante/salas', 'VisitorController::index');



$routes->get('salas/deshabilitadas', 'Salas::deshabilitadas', ['filter' => 'auth']);
$routes->get('salas/deshabilitar/(:num)', 'Salas::deshabilitar/$1', ['filter' => 'auth']);
$routes->get('salas/habilitar/(:num)', 'Salas::habilitar/$1', ['filter' => 'auth']);


$routes->get('reservas/deshabilitar/(:num)', 'Reservas::deshabilitar/$1');




$routes->get('/admin/reportes', 'Admin\ReportesController::reservas');

$routes->get('/admin/reportes/excel', 'Admin\ReportesController::exportarExcel');
$routes->get('/admin/reportes/pdf', 'Admin\ReportesController::exportarPDF');






$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes){

    $routes->get('users', 'UsersController::index');
    $routes->get('users/create', 'UsersController::create');
    $routes->post('users/store', 'UsersController::store');
    $routes->get('users/edit/(:num)', 'UsersController::edit/$1');
    $routes->post('users/update/(:num)', 'UsersController::update/$1');
    $routes->get('users/delete/(:num)', 'UsersController::delete/$1');




});

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
    $routes->get('users', 'Admin\Users::index');
    $routes->get('rooms', 'Admin\Rooms::index');
    $routes->get('reports', 'Admin\Reports::index');
});

// rutas de reservas (para todos los usuarios autenticados)
$routes->get('reservas', 'Reservations::index', ['filter' => 'auth']);
$routes->get('reservas/new', 'Reservations::create', ['filter' => 'auth']);

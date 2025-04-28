<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/profil-siswa', 'Siswa::profil');

$routes->get('/hello', function () {
    echo "Hello World";
});

$routes->get('data-siswa/(:alpha)/(:num)', 'Siswa::dataSiswa/$1/$2');

$routes->get('/modul', 'Modul::index');
$routes->post('/modul/save', 'Modul::save');

$routes->get('/registrasi', 'Registrasi::index');
$routes->post('/registrasi/save', 'Registrasi::save');

// RESTful Resource
$routes->resource('registrasiapi', ['controller' => 'UserApiController']);

// Optional manual routes (boleh dihapus karena resource sudah otomatis handle semuanya)
$routes->get('registrasiapi', 'UserApiController::index');
$routes->get('registrasiapi/(:num)', 'UserApiController::show/$1');
$routes->post('registrasiapi', 'UserApiController::create');
$routes->put('registrasiapi/(:num)', 'UserApiController::update/$1');
$routes->delete('registrasiapi/(:num)', 'UserApiController::delete/$1');

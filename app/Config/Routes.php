<?php

use CodeIgniter\Router\RouteCollection;

// Públicas
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->get('/logout', 'AuthController::logout');

// Autenticación
$routes->group('auth', function ($routes) {
    $routes->post('procesar-login', 'AuthController::procesarLogin');
    $routes->post('procesar-registro', 'AuthController::procesarRegistro');
});

// Protegidas
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('dashboard/usuarios', 'DashboardController::administrarUsuarios');
    $routes->get('dashboard/usuario/cambiar-estado/(:num)', 'DashboardController::cambiarEstadoUsuario/$1');
    $routes->get('dashboard/usuario/cambiar-nivel/(:num)', 'DashboardController::cambiarNivelUsuario/$1');

    // Perfil
    $routes->get('perfil', 'AuthController::perfil');
    $routes->post('perfil/actualizar', 'AuthController::actualizarPerfil');
    $routes->post('perfil/cambiar-password', 'AuthController::cambiarPassword'); // NUEVA RUTA
});
<?php

use CodeIgniter\Router\RouteCollection;

// Públicas
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/recuperar-password', 'AuthController::recuperarPassword');

// Autenticación
$routes->group('auth', function ($routes) {
    $routes->post('procesar-login', 'AuthController::procesarLogin');
    $routes->post('procesar-registro', 'AuthController::procesarRegistro');
    $routes->post('solicitar-recuperacion', 'AuthController::solicitarRecuperacion');
    $routes->get('resetear-password/(:any)', 'AuthController::resetearPassword/$1');
    $routes->post('actualizar-password/(:any)', 'AuthController::actualizarPassword/$1');
});

// Protegidas
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');    
    // Perfil
    $routes->get('perfil', 'AuthController::perfil');
    $routes->post('perfil/actualizar', 'AuthController::actualizarPerfil');
    $routes->post('perfil/cambiar-password', 'AuthController::cambiarPassword');
    // Administración (solo para rol Sistemas)
    $routes->group('admin', function ($routes) {
        $routes->get('usuarios', 'AdminController::index');
        $routes->get('usuarios/crear', 'AdminController::editarUsuario');
        $routes->get('usuarios/editar/(:num)', 'AdminController::editarUsuario/$1');
        $routes->post('usuarios/guardar', 'AdminController::guardarUsuario');
        $routes->post('usuarios/guardar/(:num)', 'AdminController::guardarUsuario/$1');
        $routes->get('usuarios/cambiar-aprobacion/(:num)', 'AdminController::cambiarAprobacion/$1');
        $routes->get('usuarios/resetear-password/(:num)', 'AdminController::resetearPassword/$1');
        $routes->get('usuarios/cambiar-estado/(:num)/(:any)', 'AdminController::cambiarEstado/$1/$2');
    });
});
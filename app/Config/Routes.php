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
    $routes->post('verificar-respuesta', 'AuthController::verificarRespuesta');
    $routes->post('actualizar-password-recuperacion', 'AuthController::actualizarPasswordRecuperacion'); // MOVER AQUÍ
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

    // Niveles de Excelencia
    $routes->group('niveles-excelencia', function ($routes) {
        $routes->get('/', 'NivelesExcelenciaController::index');
        $routes->get('nuevo', 'NivelesExcelenciaController::new');
        $routes->post('crear', 'NivelesExcelenciaController::create');
        $routes->get('(:num)', 'NivelesExcelenciaController::show/$1');
        $routes->get('editar/(:num)', 'NivelesExcelenciaController::edit/$1');
        $routes->post('actualizar/(:num)', 'NivelesExcelenciaController::update/$1');
        $routes->post('eliminar/(:num)', 'NivelesExcelenciaController::delete/$1');
    });

    // Modalidades
    $routes->group('modalidades', function ($routes) {
        $routes->get('/', 'ModalidadesController::index');
        $routes->get('nuevo', 'ModalidadesController::new');
        $routes->post('crear', 'ModalidadesController::create');
        $routes->get('(:num)', 'ModalidadesController::show/$1');
        $routes->get('editar/(:num)', 'ModalidadesController::edit/$1');
        $routes->post('actualizar/(:num)', 'ModalidadesController::update/$1');
        $routes->post('eliminar/(:num)', 'ModalidadesController::delete/$1');
    });
    // Representaciones
    $routes->group('representaciones', function ($routes) {
        $routes->get('/', 'RepresentacionesController::index');
        $routes->get('nuevo', 'RepresentacionesController::new');
        $routes->post('crear', 'RepresentacionesController::create');
        $routes->get('(:num)', 'RepresentacionesController::show/$1');
        $routes->get('editar/(:num)', 'RepresentacionesController::edit/$1');
        $routes->post('actualizar/(:num)', 'RepresentacionesController::update/$1');
        $routes->post('eliminar/(:num)', 'RepresentacionesController::delete/$1');
    });

    // Sedes
    $routes->group('sedes', function ($routes) {
        $routes->get('/', 'SedesController::index');
        $routes->get('nuevo', 'SedesController::new');
        $routes->post('crear', 'SedesController::create');
        $routes->get('(:num)', 'SedesController::show/$1');
        $routes->get('editar/(:num)', 'SedesController::edit/$1');
        $routes->post('actualizar/(:num)', 'SedesController::update/$1');
        $routes->post('eliminar/(:num)', 'SedesController::delete/$1');
    });

    // Tipo Actividades
    $routes->group('tipo-actividades', function ($routes) {
        $routes->get('/', 'TipoActividadesController::index');
        $routes->get('nuevo', 'TipoActividadesController::new');
        $routes->post('crear', 'TipoActividadesController::create');
        $routes->get('(:num)', 'TipoActividadesController::show/$1');
        $routes->get('editar/(:num)', 'TipoActividadesController::edit/$1');
        $routes->post('actualizar/(:num)', 'TipoActividadesController::update/$1');
        $routes->post('eliminar/(:num)', 'TipoActividadesController::delete/$1');
    });

    // Estado Concursos
    $routes->group('estado-concursos', function ($routes) {
        $routes->get('/', 'EstadoConcursosController::index');
        $routes->get('nuevo', 'EstadoConcursosController::new');
        $routes->post('crear', 'EstadoConcursosController::create');
        $routes->get('(:num)', 'EstadoConcursosController::show/$1');
        $routes->get('editar/(:num)', 'EstadoConcursosController::edit/$1');
        $routes->post('actualizar/(:num)', 'EstadoConcursosController::update/$1');
        $routes->post('eliminar/(:num)', 'EstadoConcursosController::delete/$1');
    });

    // Actividades
    $routes->group('actividades', function ($routes) {
        $routes->get('/', 'ActividadesController::index');
        $routes->get('calendario', 'ActividadesController::calendario');
        $routes->get('lista', 'ActividadesController::lista');
        $routes->get('nuevo', 'ActividadesController::new');
        $routes->post('crear', 'ActividadesController::create');
        $routes->get('(:num)', 'ActividadesController::show/$1');
        $routes->get('editar/(:num)', 'ActividadesController::edit/$1');
        $routes->post('actualizar/(:num)', 'ActividadesController::update/$1');
        $routes->post('eliminar/(:num)', 'ActividadesController::delete/$1');
        $routes->get('api/actividades', 'ActividadesController::apiActividades');
    });

    // Rutas para Biblioteca (Agrupadas)
    $routes->group('biblioteca', function ($routes) {
        $routes->get('/', 'BibliotecaController::index');
        $routes->get('nuevo', 'BibliotecaController::new');
        $routes->post('crear', 'BibliotecaController::create');
        $routes->get('(:num)', 'BibliotecaController::show/$1');
        $routes->get('editar/(:num)', 'BibliotecaController::edit/$1');
        $routes->post('actualizar/(:num)', 'BibliotecaController::update/$1');
        $routes->post('eliminar/(:num)', 'BibliotecaController::delete/$1');
    });
});

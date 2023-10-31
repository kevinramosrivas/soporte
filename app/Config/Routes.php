<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/**
 * Define un grupo de rutas para la URL raíz con el espacio de nombres 'App\Controllers\Login'.
 * El grupo contiene una sola ruta GET que se asigna al método 'index' de la clase 'LoginController'.
 *
 * @param object $routes El objeto de rutas para definir el grupo.
 * @return void
 */

$routes->group('/', ['namespace' => 'App\Controllers\Login'], function ($routes) {
    //si es que la sesion esta iniciada, redirigir a la pagina principal
    $routes->get('', 'LoginController::index');
    $routes->get('logout', 'LoginController::logout');
    $routes->get('home', 'LoginController::home');

});
$routes->group('login', ['namespace' => 'App\Controllers\Login'], function ($routes) {
    $routes->get('', 'LoginController::index');
    $routes->post('login', 'LoginController::login');
    $routes->get('register', 'LoginController::register');
});




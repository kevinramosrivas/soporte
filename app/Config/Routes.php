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
    $routes->get('', 'LoginController::index');

});
$routes->group('login', ['namespace' => 'App\Controllers\Login'], function ($routes) {
    $routes->get('', 'LoginController::index');
    $routes->get('login', 'LoginController::login');
});



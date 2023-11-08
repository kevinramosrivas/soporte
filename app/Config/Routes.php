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


$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('home', 'AdminController::index');
    $routes->get('registerEntryLab', 'AdminController::registerEntryLab');
    $routes->get('registerExitLab', 'AdminController::registerExitLab');
    $routes->get('viewRegisterEntryLab', 'AdminController::viewRegisterEntryLab');
    $routes->get('users', 'AdminController::users');
    $routes->post('logout', 'AdminController::logout');
    $routes->post('registerUser', 'AdminController::registerNewUser');
    $routes->post('userDelete', 'AdminController::deleteUser');
    $routes->post('editUser', 'AdminController::editUser');
    $routes->post('searchUser', 'AdminController::searchUser');
    $routes->post('registerNewEntryLab', 'AdminController::registerNewEntryLab');
    $routes->post('registerNewExitLab', 'AdminController::registerNewExitLab');
});






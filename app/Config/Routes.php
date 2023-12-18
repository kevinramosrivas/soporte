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
    $routes->get('users', 'AdminController::users');
    $routes->get('usersInactive', 'AdminController::usersInactive');
    $routes->get('logout', 'AdminController::logout');
    $routes->post('registerUser', 'AdminController::registerNewUser');
    $routes->post('userDelete', 'AdminController::deleteUser');
    $routes->post('editUser', 'AdminController::editUser');
    $routes->post('searchUser', 'AdminController::searchUser');
    $routes->post('deleteRegisterEntryLab', 'AdminController::deleteRegisterEntryLab');
    $routes->post('restoreUser', 'AdminController::restoreUser');
});

$routes->group('user', ['namespace' => 'App\Controllers\User'], function ($routes) {
    $routes->post('registerNewEntryLab', 'UserController::registerNewEntryLab');
    $routes->post('registerNewExitLab', 'UserController::registerNewExitLab');
    $routes->get('registerEntryLab', 'UserController::registerEntryLab');
    $routes->get('registerExitLab', 'UserController::registerExitLab');
    $routes->get('viewRegisterEntryLab','UserController::viewRegisterEntryLab');
    $routes->get('profile','UserController::profile');
    $routes->get('intermediary','UserController::intermediary');
    $routes->get('passwordManager','UserController::passwordManager');
    $routes->get('closeTemporarySession','UserController::closeTempSession');
    $routes->post('verifyIdentity', 'UserController::verifyIdentity');
    $routes->post('searchEntryLabByDocLab','UserController::searchEntryLabByDocLab');
    $routes->post('searchEntryLabByDatetime','UserController::searchEntryLabByDatetime');
    $routes->post('updateProfile','UserController::updateProfile');
    $routes->post('createNewAccountPassword','UserController::createNewAccountPassword');
    $routes->post('editPassword','UserController::editPassword');
    $routes->get('deletePassword/(:num)','UserController::deletePassword/$1');



});

$routes->group('student', ['namespace' => 'App\Controllers\Student'], function ($routes) {
    $routes->get('home', 'StudentController::index');
    $routes->get('logout', 'StudentController::logout');
});






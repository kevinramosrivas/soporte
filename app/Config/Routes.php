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

$routes->group('/', ['namespace' => 'App\Controllers'], function ($routes) {
    //si es que la sesion esta iniciada, redirigir a la pagina principal
    $routes->get('', 'LoginController::index');
    $routes->get('home', 'LoginController::home');

});

#Rutas para DashboardController

$routes->group('dashboard', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('admin', 'DashboardController::indexAdmin');
    $routes->get('user', 'DashboardController::indexUser');
});
#Rutas para DocumentsController
$routes->group('documents',['namespace' =>'App\Controllers'], function($routes){
    $routes->get('manageDocumentation', 'DocumentsController::manageDocumentation');
    $routes->get('manageCategories', 'DocumentsController::manageCategories');
    $routes->post('addManual', 'DocumentsController::addManual');
    $routes->get('delete/(.*)', 'DocumentsController::deleteDocument/$1');
    $routes->post('edit/(.*)', 'DocumentsController::editDocument/$1');
    $routes->post('addCategory', 'DocumentsController::addCategory');
    //se pasa el id de la categoria a eliminar que es un string que es un uuid v4 10fd259d-2733-4bf5-8e58-ce36ecfaf1cb
    $routes->get('deleteCategory/(.*)', 'DocumentsController::deleteCategory/$1');
    $routes->post('editCategory/(.*)', 'DocumentsController::editCategory/$1');
    $routes->get('showDocuments', 'DocumentsController::showDocuments');
});
#Rutas para LabsController
$routes->group('labs',['namespace' =>'App\Controllers'], function($routes){
    $routes->get('registerEntryLab', 'LabsController::registerEntryLab');
    $routes->get('registerExitLab', 'LabsController::registerExitLab');
    $routes->get('viewRegisterEntryLab', 'LabsController::viewRegisterEntryLab');
    $routes->post('registerNewEntryLab', 'LabsController::registerNewEntryLab');
    $routes->post('registerNewExitLab', 'LabsController::registerNewExitLab');
    $routes->post('searchEntryLabByDocLab', 'LabsController::searchEntryLabByDocLab');
    $routes->post('searchEntryLabByDatetime', 'LabsController::searchEntryLabByDatetime');
    $routes->post('deleteRegisterEntryLab', 'LabsController::deleteRegisterEntryLab');
});
#Rutas para LoginController
$routes->group('login', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('', 'LoginController::index');
    $routes->post('login', 'LoginController::login');
    $routes->get('logout', 'LoginController::logout');
});
#Rutas para PasswordsController
$routes->group('passwords',['namespace' =>'App\Controllers'], function($routes){
    $routes->get('passwordManager','PasswordsController::passwordManager');
    $routes->get('closeTemporarySession','PasswordsController::closeTempSession');
    $routes->post('verifyIdentity', 'PasswordsController::verifyIdentity');
    $routes->post('createNewAccountPassword','PasswordsController::createNewAccountPassword');
    $routes->post('editPassword','PasswordsController::editPassword');
    $routes->get('deletePassword/(.*)','PasswordsController::deletePassword/$1');
    $routes->get('intermediary','PasswordsController::intermediary');
});
#Rutas para ProfilesController
$routes->group('profiles', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('profile','ProfilesController::profile');
    $routes->post('updateProfile','ProfilesController::updateProfile');
});

#Rutas para UsersController
$routes->group('users', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('users', 'UsersController::users');
    $routes->get('usersInactive', 'UsersController::usersInactive');
    $routes->get('logout', 'UsersController::logout');
    $routes->post('registerUser', 'UsersController::registerNewUser');
    $routes->post('userDelete', 'UsersController::deleteUser');
    $routes->post('editUser', 'UsersController::editUser');
    $routes->post('searchUser', 'UsersController::searchUser');
    $routes->post('restoreUser', 'UsersController::restoreUser');
});


#Rutas para TasksController
$routes->group('tasks', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('hola', 'TasksController::hola');
    $routes->get('tasks', 'TasksController::tasks');
    $routes->post('registerTask', 'TasksController::registerTask');
    $routes->post('editTask', 'TasksController::editTask');
    //se pasa el id de la tarea a eliminar que es un string que es un id numerico
    $routes->get('deleteTask/(:num)', 'TasksController::deleteTask/$1');
    $routes->post('searchTask', 'TasksController::searchTask');
    $routes->post('restoreTask', 'TasksController::restoreTask');
    $routes->post('registerComment', 'TasksController::registerComment');
    $routes->post('deleteComment', 'TasksController::deleteComment');
    $routes->post('editComment', 'TasksController::editComment');
    $routes->post('searchComment', 'TasksController::searchComment');
    $routes->post('restoreComment', 'TasksController::restoreComment');
    $routes->post('changeStatus', 'TasksController::changeStatus');
    $routes->post('searchTaskByStatus', 'TasksController::searchTaskByStatus');
    $routes->post('searchTaskByUser', 'TasksController::searchTaskByUser');
    $routes->post('searchTaskByDate', 'TasksController::searchTaskByDate');
    $routes->post('searchTaskByTitle', 'TasksController::searchTaskByTitle');
    $routes->post('searchTaskByDescription', 'TasksController::searchTaskByDescription');
    $routes->post('searchTaskByAssignedTo', 'TasksController::searchTaskByAssignedTo');
    $routes->post('searchTaskByFollowupCode', 'TasksController::searchTaskByFollowupCode');
    $routes->post('searchTaskByUserAndStatus', 'TasksController::searchTaskByUserAndStatus');
    $routes->post('searchTaskByUserAndDate', 'TasksController::searchTaskByUserAndDate');
    $routes->post('searchTaskByUserAndTitle', 'TasksController::searchTaskByUserAndTitle');
    $routes->post('searchTaskByUserAndDescription', 'TasksController::searchTaskByUserAndDescription');
    $routes->post('searchTaskByUserAndAssignedTo', 'TasksController::searchTaskByUserAndAssignedTo');
    $routes->post('searchTaskByUserAndFollowupCode', 'TasksController::searchTaskByUserAndFollowupCode');

});







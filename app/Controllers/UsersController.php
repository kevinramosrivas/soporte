<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Entities\User;
use App\Helpers\VerifyAdmin;
use App\Entities\UserLog;
use Exception;


class UsersController extends BaseController
{
    public function users()
    {
        $session = session();
        //usar el helper para verificar si el usuario es administrador
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            // obtener todos los usuarios
            $model = model('UserModel');
            $users = $model->getActiveUsers();
            // solo mostrar los usuarios activos
            $data = [
                'users' => $users,
            ];
            return view('Admin/users_active', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function usersInactive()
    {
        $session = session();
        //usar el helper para verificar si el usuario es administrador
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            // obtener todos los usuarios
            $model = model('UserModel');
            $users = $model->getInactiveUsers();
            // solo mostrar los usuarios activos
            $data = [
                'users' => $users,
            ];
            return view('Admin/users_inactive', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerNewUser()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $data = array(
                'id_user' => $this->request->getPost('id_user'),
                'type' => $this->request->getPost('type'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'user_status' => 1,
            );
            $user = new User($data);
            $model = model('UserModel');
            //verificar si el usuario ya existe en la base de datos
            $user_db = $model->getUserByEmail($data['email']);
            if($user_db != null){
                $session->setFlashdata('error', 'El usuario ya existe');
                return redirect()->to(site_url('users/users'));
            }
            $model->insert($user);
            //añadir al user log
            $log_model = model('UserLogModel');
            $log = [
                'id_user' => $session->id_user,
                'action' => 'creó un nuevo usuario con el correo '.$data['email'],
            ];
            $log_entity = new UserLog($log);
            $log_model->insert($log_entity);
            return redirect()->to(site_url('users/users'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function deleteUser()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $id_user = $this->request->getPost('id_user');
            $model = model('UserModel');
            $model->desactivateUser($id_user);
            //destruir la sesion del usuario que se eliminó
            if($session->id_user == $id_user){
                $session->destroy();
            }  
            //añadir al user log
            $log_model = model('UserLogModel');
            //obtenemos el usuario que se va a eliminar
            $user = $model->getUserById($id_user);
            $log = [
                'id_user' => $session->id_user,
                'action' => 'puso en estado inactivo al usuario con el correo '.$user['email'],
            ];
            $log_entity = new UserLog($log);
            $log_model->insert($log_entity);
            return redirect()->to(site_url('users/users'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function editUser()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $data = [
                'id_user' => $this->request->getPost('id_user'),
                'type' => $this->request->getPost('type'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'user_status' => $this->request->getPost('user_status'),
            ];
            if($data['password'] == ''){
                unset($data['password']);
            }
            $model = model('UserModel');
            $user = new User($data);
            $model->update($data['id_user'], $user);
            //añadir al user log
            $log_model = model('UserLogModel');
            $log = [
                'id_user' => $session->id_user,
                'action' => 'editó el usuario con el correo '.$data['email'],
            ];
            $log_entity = new UserLog($log);
            $log_model->insert($log_entity);
            return redirect()->to(site_url('users/users'));
        }else{
            return redirect()->to(site_url('login'));
        }
    }
    public function searchUser()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $search = $this->request->getPost('search');
            $model = model('UserModel');
            $user = $model->searchUser($search);
            $data = [
                'users' => $user,
            ];
            return view('Admin/users', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function restoreUser(){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $id_user = $this->request->getPost('id_user');
            $model = model('UserModel');
            $model->activateUser($id_user);
            //añadir al user log
            $log_model = model('UserLogModel');
            //obtenemos el usuario que se va a eliminar
            $user = $model->getUserById($id_user);
            $log = [
                'id_user' => $session->id_user,
                'action' => 'puso en estado activo al usuario con el correo '.$user['email'],
            ];
            $log_entity = new UserLog($log);
            $log_model->insert($log_entity);
            return redirect()->to(site_url('users/users'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }

}
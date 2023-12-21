<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Entities\PrestamosLab;
use App\Entities\User;
use App\Helpers\VerifyAdmin;



class AdminController extends BaseController
{
    /**
     * Método que muestra la página principal del panel de administración.
     * Si el usuario ha iniciado sesión y es un administrador, se muestra el número de usuarios registrados.
     * Si no ha iniciado sesión o no es un administrador, se redirige a la página de inicio de sesión.
     *
     * @return mixed
     */
    public function index()
    {
        /**
         * Verifica si el usuario ha iniciado sesión como administrador y muestra la vista de inicio del panel de administración.
         * Recopila el número total de usuarios y el número de usuarios que están ocupando un laboratorio en el día de hoy.
         * 
         * @return mixed
         */
        $session = session();
        //usar el helper para verificar si el usuario es administrador
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            //recolectamos los eventos recientes en user log
            $model = model('UserLogModel');
            $logs = $model->getAllLog();
            $model_user = model('UserModel');
            $users = count($model_user->getActiveUsers());
            $model_prestamos = model('PrestamosLabModel');
            $students_using_lab = count($model_prestamos->getStudentsUsingLab());
            //se calculo la diferencia entre la fecha actual y la fecha de creacion del registro
            $data = [
                'logs' => $logs,
                'now' => date('Y-m-d H:i:s'),
                'users' => $users,
                'students_using_lab' => $students_using_lab,
            ];
            return view('Admin/home', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    
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
                return redirect()->to(site_url('admin/users'));
            }
            $model->insert($user);
            //añadir al user log
            $log_model = model('UserLogModel');
            $log = [
                'id_user' => $session->id_user,
                'action' => 'creó un nuevo usuario con el correo '.$data['email'],
            ];
            $log_model->insert($log);
            return redirect()->to(site_url('admin/users'));
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
            $log_model->insert($log);
            return redirect()->to(site_url('admin/users'));
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
            $log_model->insert($log);
            return redirect()->to(site_url('admin/users'));
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
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url('login'));
    }
    public function deleteRegisterEntryLab(){
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify) {
            $id_prestamo = $this->request->getPost('id_prestamo');
            $model = model('PrestamosLabModel');
            $model->delete($id_prestamo);
            //añadir al user log
            $log_model = model('UserLogModel');
            $log = [
                'id_user' => $session->id_user,
                'action' => 'Eliminó el registro de entrada al laboratorio con el id: '.$id_prestamo,
            ];
            return redirect()->to(site_url('user/viewRegisterEntryLab'));
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
            $log_model->insert($log);
            return redirect()->to(site_url('admin/usersInactive'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }


}

?>
<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Entities\PrestamosLab;
use App\Entities\User;



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
        if ($session->isLoggedIn && $session->type == 'ADMINISTRADOR') {
            //recolectar el numero de usuarios
            $user_model = model('UserModel');
            $users = $user_model->findAll();
            // obtener el numero de usuarios ocupando un laboratorio
            $prestamos_model = model('PrestamosLabModel');
            $users_lab = $prestamos_model->findAll();
            // que sean del dia de hoy
            foreach ($users_lab as $key => $value) {
                if($value['hour_entry'] !== $value['hour_exit']){
                    unset($users_lab[$key]);
                }
            }
            $students_in_lab = count($users_lab);
            // contar el numero de usuarios de tipo admin y user
            $users = count($users);
            $data = [
                'users' => $users,
                'students_in_lab' => $students_in_lab,
            ];
            return view('Admin/home', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    
    public function users()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'ADMINISTRADOR') {
            // obtener todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            // solo mostrar los usuarios activos
            $data = [
                'users' => $users,
            ];
            return view('Admin/users', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerNewUser()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'ADMINISTRADOR') {
            $data = [
                'id_user' => $this->request->getPost('id_user'),
                'type' => $this->request->getPost('type'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ];
            $user = new User($data);
            $model = model('UserModel');
            //verificar si el usuario ya existe en la base de datos
            $user_db = $model->getUserByEmail($data['email']);
            if($user_db != null){
                $session->setFlashdata('error', 'El usuario ya existe');
                return redirect()->to(site_url('admin/users'));
            }
            $model->insert($user);
            return redirect()->to(site_url('admin/users'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function deleteUser()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'ADMINISTRADOR') {
            $id_user = $this->request->getPost('id_user');
            $model = model('UserModel');
            $model->desactivateUser($id_user);
            return redirect()->to(site_url('admin/users'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function editUser()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'ADMINISTRADOR') {
            $data = [
                'id_user' => $this->request->getPost('id_user'),
                'type' => $this->request->getPost('type'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'active' => $this->request->getPost('active'),
            ];
            $user = new User($data);
            $model = model('UserModel');
            if (isset($data['password'])) {
                $data['password'] = (string) $data['password'];
                $data['password'] = $user->encriptPassword($data['password']);
            }
            else{
                $data['password'] = null;
            }
            $model->updateUser($data['id_user'], $data);
            return redirect()->to(site_url('admin/users'));
        }else{
            return redirect()->to(site_url('login'));
        }
    }
    public function searchUser()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'ADMINISTRADOR') {
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
        if ($session->isLoggedIn && $session->type == 'ADMINISTRADOR') {
            $id_prestamo = $this->request->getPost('id_prestamo');
            $model = model('PrestamosLabModel');
            $model->delete($id_prestamo);
            return redirect()->to(site_url('user/viewRegisterEntryLab'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }


}

?>
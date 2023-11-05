<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Entities\User;

class AdminController extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            //recolectar el numero de usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            // contar el numero de usuarios de tipo admin y user
            $users = count($users);
            $data = [
                'users' => $users,
            ];
            $data = [
                'users' => $users,
            ];
            return view('Admin/home', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerEntryLab()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            return view('Admin/register_entry_lab');
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerExitLab()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            return view('Admin/register_out_lab');
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function viewRegisterEntryLab()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            return view('Admin/view_register_entry_lab');
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function users()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            // obtener todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
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
        if ($session->isLoggedIn && $session->type == 'admin') {
            $data = [
                'id_user' => $this->request->getPost('id_user'),
                'type' => $this->request->getPost('type'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ];
            $user = new User($data);
            $model = model('UserModel');
            $model->insert($user);
            return redirect()->to(site_url('admin/users'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function deleteUser()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            $id_user = $this->request->getPost('id_user');
            $model = model('UserModel');
            $model->delete($id_user);
            return redirect()->to(site_url('admin/users'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function editUser()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            $data = [
                'id_user' => $this->request->getPost('id_user'),
                'type' => $this->request->getPost('type'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ];
            if($data['password'] == ''){
                unset($data['password']);
            }
            $user = new User($data);
            $model = model('UserModel');    
            $model->update($data['id_user'], $user);
            return redirect()->to(site_url('admin/users'));
        }else{
            return redirect()->to(site_url('login'));
        }
    }
    public function searchUser()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
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
}

?>
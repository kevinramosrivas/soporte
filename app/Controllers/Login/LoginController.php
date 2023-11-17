<?php
namespace App\Controllers\Login;
use App\Controllers\BaseController;
use App\Entities\User;


/**
 * Class LoginController
 * @package App\Controllers\Login
 */
class LoginController extends BaseController
{
    /**
     * Display the login view.
     *
     * @return string
     */
    public function index(): string
    {
        return view('Login/login');
    }
    public function login()
    {
        //recuperar la informacion del formulario
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        //consulatar con el modelo
        $userModel = model('UserModel');
        $user = $userModel->getUser($email, $password);
        if($user != null){
            //crear la sesion
            $session = session();
            $session->set([
                'id_user' => $user['id_user'],
                'type' => $user['type'],
                'username' => $user['username'],
                'email' => $user['email'],
                'isLoggedIn' => true,
                'active' => $user['active']
            ]);
            if ($user['type'] == 'admin' && $user['active'] == 1) {
                return redirect()->to(site_url('admin/home'));
            } else if ($user['type'] == 'user') {
                return redirect()->to(site_url('user/home'));
            }
            else if (($user['type'] == 'admin' ||$user['type'] == 'user') && $user['active'] == 0) {
                $session = session();
                //añadir un mensaje de error
                $session->setFlashdata('login_error', 'Usuario inactivo, por favor contacte con el administrador');
                return redirect()->to(site_url('login'));
            }

            else{
                $session = session();
                //añadir un mensaje de error
                $session->setFlashdata('login_error', 'Tipo de usuario incorrecto');
                return redirect()->to(site_url('login'));
            }
        }else{
            $session = session();
            //añadir un mensaje de error
            $session->setFlashdata('login_error', 'Usuario o contraseña incorrectos');
            //redireccionar al login con el mensaje de error
            return redirect()->to(site_url('login'));
        }
    }
    public function register()
    {
        $data = [
            'id_user' => '6',
            'type' => 'admin',
            'username' => 'admdADSFin',
            'email' => '1234@gmail.com',
            'password' => '123456789',
        ];
        $user = new User($data);
        $model = model('UserModel');
        $model->insert($user);
    }
}

?>
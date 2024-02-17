<?php
namespace App\Controllers;
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
    public function index()
    {
        #verificar si es que es la primera vez que se accede al sistema y si hay usuarios registrados
        $userModel = model('UserModel');
        $users = $userModel->findAll();
        //si es que no hay usuarios registrados crear un usuario administrador
        if(empty($users)){
            $this->register();
            //redireccionar al login
            return view('Login/login');
        }
        $session = session();
        if(isset($session->isLoggedIn)){
            if($session->type == 'ADMINISTRADOR' && $session->user_status == 1){
                return redirect()->to(base_url('dashboard/admin'));
            }else if($session->type == 'BOLSISTA' && $session->user_status == 1){
                return redirect()->to(base_url('dashboard/user'));
            }
        }
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
            if($user['user_status'] == 0){
                $session = session();
                //añadir un mensaje de error
                $session->setFlashdata('login_error', 'Usuario desactivado, contacte con el administrador');
                //redireccionar al login con el mensaje de error
                return redirect()->to(site_url('login'));
            }
            else{
                //crear la sesion
                $session = session();
                //regenerar la sesion
                session_regenerate_id();
                //crear y guardar la sesion
                $session->set([
                    'id_user' => $user['id_user'],
                    'id_user_uuid' => $user['id_user_uuid'],
                    'type' => $user['type'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'isLoggedIn' => true,
                    'user_status' => $user['user_status']
                ]);
                if($user['type'] == 'ADMINISTRADOR'){
                    return redirect()->to(base_url('dashboard/admin'));
                }else if($user['type'] == 'BOLSISTA'){
                    return redirect()->to(base_url('dashboard/user'));
                }
            }
        }else{
            $session = session();
            //añadir un mensaje de error
            $session->setFlashdata('login_error', 'Usuario o contraseña incorrectos');
            //redireccionar al login con el mensaje de error
            return redirect()->to(site_url('login'));
        }
    }
    private function register()
    {
        $data = [
            'id_user' => '',
            'type' => 'ADMINISTRADOR',
            'username' => 'ADM_SOPORTE',
            'email' => 'admin_soporte@unmsm.edu.pe',	
            'password' => 'soporteFISI',
            'user_status' => '1'
        ];
        $user = new User($data);
        $model = model('UserModel');
        $model->insert($user);
    }
      
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url('login'));
    }
}

?>
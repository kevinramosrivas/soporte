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
        $data = [
            'id_user' => '6',
            'type' => 'admin',
            'username' => 'admdADSFin',
            'email' => 'kevi1234n@gmail.com',
            'password' => '12345689abc',
        ];
        $user = new User($data);
        $model = model('UserModel');
        $model->insert($user);
    }
}

?>
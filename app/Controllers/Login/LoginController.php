<?php
namespace App\Controllers\Login;
use App\Controllers\BaseController;


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
    public function login(): string
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        if ($username == 'admin' && $password == 'admin') {
            return view('Login/success');
        } else {
            return view('Login/login');
        }
    }
}

?>
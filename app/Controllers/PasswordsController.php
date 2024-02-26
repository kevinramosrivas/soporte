<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Entities\Passwords;
use App\Entities\UserLog;


class PasswordsController extends BaseController{
    public function intermediary(){
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $uniquePassword = $session->getTempdata('uniquePassword');
            $token = $session->getTempdata('token');
            $id_user = $session->id_user;
            if(password_verify($id_user.$uniquePassword, $token)){
                return redirect()->to(site_url('passwords/passwordManager'));
            }
            $data = [
                'user' => $session,
            ];
            return view('User/intermediary', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function verifyIdentity(){
        $timeLeft = 3000;
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $data = [
                'id_user' => $session->id_user,
                //esta es la contraseña actual
                'password' => $this->request->getPost('password'),
            ];
            // validar los datos
            $validation = \Config\Services::validation();
            $validation->setRules([
                'password' => 'required|min_length[8]',
            ]);
            if (!$validation->run($data)) {
                $session->setFlashdata('error_password_manager', 'Los datos ingresados no son correctos');
                return redirect()->to(site_url('passwords/intermediary'));
            }
            $model = model('UserModel');
            $user = $model->getUserById($data['id_user']);
            if($user != null){
                if(password_verify($data['password'], $user['password'])){
                    $variableCrypto = openssl_random_pseudo_bytes(16);
                    //establecer una variable de sesion que dure 5 minutos
                    $session->setTempdata('uniquePassword', $variableCrypto, $timeLeft);
                    $token = password_hash($user['id_user'].$variableCrypto, PASSWORD_DEFAULT);
                    $session->setTempdata('token', $token, $timeLeft);
                    //tomar la hora actual y sumarle el tiempo de expiracion
                    $session->setTempdata('dateExpire', date('H:i:s', strtotime('+'.$timeLeft.'seconds')) , $timeLeft);
                    return redirect()->to(site_url('passwords/passwordManager'));
                }
                else{
                    $session->setFlashdata('error_password_manager', 'La contraseña es incorrecta');
                    return redirect()->to(site_url('passwords/intermediary'));
                }
            }
            else{
                $session->setFlashdata('error_password_manager', 'El usuario no existe');
                return redirect()->to(site_url('passwords/intermediary'));
            }
        }
        else {
            return redirect()->to(site_url('login'));
        }
    }
    public function passwordManager(){
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $uniquePassword = $session->getTempdata('uniquePassword');
            $token = $session->getTempdata('token');
            $id_user = $session->id_user;
            if(password_verify($id_user.$uniquePassword, $token)){
                // obtener todas las cuentas
                $model = model('PasswordsModel');
                $passwords = $model->getPasswords($session->type);
                if($passwords == null){
                    $session->setFlashdata('no_records_password_manager','No se encontraron registros');
                }
                $data = [
                    'passwords' => $passwords,
                    'session' => $session,
                ];
                return view('User/password_manager', $data);
            }
            else{
                return redirect()->to(site_url('passwords/intermediary'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function closeTempSession(){
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $session->removeTempdata('uniquePassword');
            $session->removeTempdata('token');
            $session->removeTempdata('dateExpire');
            return redirect()->to(site_url('passwords/intermediary'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function createNewAccountPassword(){
        $session = session();
        $uniquePassword = $session->getTempdata('uniquePassword');
        $token = $session->getTempdata('token');
        $id_user = $session->id_user;
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            if(password_verify($id_user.$uniquePassword, $token)){
                $data = [
                    'registrar_id' => $session->id_user,
                    'typeAccount' => $this->request->getPost('typeAccount'),
                    'accountName' => $this->request->getPost('acountname'),
                    'username' => $this->request->getPost('username'),
                    'password' => $this->request->getPost('password'),
                    'level' => $this->request->getPost('level'),
                    'additionalInfo' => $this->request->getPost('additionalInfo'),
                ];
                // validar los datos
                $validation = \Config\Services::validation();
                //validar que los campos no esten vacios y que sean de maximo 120 caracteres
                $validation->setRules([
                    'typeAccount' => 'required|max_length[120]',
                    'accountName' => 'required|max_length[120]',
                    'username' => 'required|max_length[120]',
                    'password' => 'required|max_length[120]',
                    'additionalInfo' => 'max_length[120]',
                    'level' => 'required|max_length[120]',
                ]);
                if (!$validation->run($data)) {
                    $session->setFlashdata('error', 'Los datos ingresados no son correctos');
                    return redirect()->to(site_url('passwords/passwordManager'));
                }
                $model = model('PasswordsModel');
                $password = new Passwords($data);
                $model->insert($password);
                //registrar en el log
                $model_log = model('UserLogModel');
                $log = [
                    'id_user' => $session->id_user,
                    'action' => 'registro una nueva cuenta de '.$data['typeAccount'].' con el nombre de '.$data['accountName'],
                ];
                $log_entity = new UserLog($log);
                $model_log->insert($log_entity);
                $session->setFlashdata('success', 'La cuenta se registro correctamente');
                return redirect()->to(site_url('passwords/passwordManager'));
            }
            else{
                return redirect()->to(site_url('passwords/intermediary'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function editPassword(){
        $session = session();
        $uniquePassword = $session->getTempdata('uniquePassword');
        $token = $session->getTempdata('token');
        $id_user = $session->id_user;
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            if(password_verify($id_user.$uniquePassword, $token)){
                $data = [
                    'id_password' => $this->request->getPost('id_password'),
                    'typeAccount' => $this->request->getPost('edit-account-type'),
                    'accountName' => $this->request->getPost('edit-account-name'),
                    'username' => $this->request->getPost('edit-username'),
                    'password' => $this->request->getPost('edit-password'),
                    'level' => $this->request->getPost('edit-level'),
                    'additionalInfo' => $this->request->getPost('edit-additional-info'),
                ];
                // validar los datos
                $validation = \Config\Services::validation();
                $validation->setRules([
                    'id_password' => 'required',
                    'typeAccount' => 'required',
                    'accountName' => 'required',
                    'username' => 'required',
                    'level' => 'required',
                ]);
                if (!$validation->run($data)) {
                    $session->setFlashdata('error_password_manager', 'Los datos ingresados no son correctos');
                    return redirect()->to(site_url('passwords/passwordManager'));
                }
                $model = model('PasswordsModel');
                //obtener la contraseña actual
                $password = $model->getPasswordById($data['id_password']);
                if($data['password'] == ''){
                    $data['password'] = $password['password'];
                }
                $password = new Passwords($data);
                $model->update($data['id_password'], $password);
                //registrar en el log
                $model_log = model('UserLogModel');
                $log = [
                    'id_user' => $session->id_user,
                    'action' => 'edito la cuenta de '.$data['typeAccount'].' con el nombre de '.$data['accountName'],
                ];
                $log_entity = new UserLog($log);
                $model_log->insert($log_entity);
                $session->setFlashdata('success', 'La cuenta se actualizo correctamente');
                return redirect()->to(site_url('passwords/passwordManager'));
            }
            else{
                return redirect()->to(site_url('passwords/intermediary'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    //UserController::deletePassword/$1
    public function deletePassword($id_password){
        $session = session();
        $uniquePassword = $session->getTempdata('uniquePassword');
        $token = $session->getTempdata('token');
        $id_user = $session->id_user;
        
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            if(password_verify($id_user.$uniquePassword, $token)){
                $model = model('PasswordsModel');
                $password = $model->getPasswordById($id_password);
                $model->delete($id_password);
                //registrar en el log
                $model_log = model('UserLogModel');
                $log = [
                    'id_user' => $session->id_user,
                    'action' => 'elimino la cuenta de '.$password['typeAccount'].' con el nombre de '.$password['accountName'],
                ];
                $log_entity = new UserLog($log);
                $model_log->insert($log_entity);
                $session->setFlashdata('success', 'La cuenta se elimino correctamente');
                return redirect()->to(site_url('passwords/passwordManager'));
            }
            else{
                return redirect()->to(site_url('passwords/intermediary'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
}

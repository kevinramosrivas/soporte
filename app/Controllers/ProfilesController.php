<?php


namespace App\Controllers;
use App\Controllers\BaseController;


class ProfilesController extends BaseController
{
    public function profile()
    {
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $data = [
                'user' => $session,
            ];
            return view('User/profile', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function updateProfile(){
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $data = [
                'id_user' => $session->id_user,
                //esta es la contraseña actual
                'password' => $this->request->getPost('password'),
                //esta es la nueva contraseña
                'newpassword' => $this->request->getPost('newpassword'),
                //esta es la confirmacion de la nueva contraseña
                'renewpassword' => $this->request->getPost('renewpassword'),
            ];
            // validar los datos
            $validation = \Config\Services::validation();
            $validation->setRules([
                'password' => 'required|min_length[8]',
                'newpassword' => 'required|min_length[8]',
                'renewpassword' => 'required|min_length[8]|matches[newpassword]',
            ]);
            if (!$validation->run($data)) {
                $session->setFlashdata('error', 'Los datos ingresados no son correctos');
                return redirect()->to(site_url('profiles/profile'));
            }
            $model = model('UserModel');
            $user = $model->getUserById($data['id_user']);
            if($user != null){
                if(password_verify($data['password'], $user['password'])){
                    $user['password'] = password_hash($data['newpassword'], PASSWORD_DEFAULT);
                    $model->update($user['id_user'], $user);
                    $session->setFlashdata('success', 'La contraseña se actualizo correctamente');
                    return redirect()->to(site_url('profiles/profile'));
                }
                else{
                    $session->setFlashdata('error', 'La contraseña actual es incorrecta');
                    return redirect()->to(site_url('profiles/profile'));
                }
            }
            else{
                $session->setFlashdata('error', 'El usuario no existe');
                return redirect()->to(site_url('profiles/profile'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
}
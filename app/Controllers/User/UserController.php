<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Entities\PrestamosLab;
use App\Models\PrestamosLabModel;
use App\Entities\User;

class UserController extends BaseController
{
    public function registerEntryLab()
    {
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) { 
            return view('User/register_entry_lab');
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerNewEntryLab()
    {
        /**
         * Registra la entrada de un usuario en el laboratorio.
         *
         * @return \CodeIgniter\HTTP\RedirectResponse Redirige a la página de registro de entrada si hay un error o a la página de inicio de sesión si el usuario no está autenticado o no es un administrador.
         */
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $data = [
                'num_lab' => $this->request->getPost('num_laboratorio'),
                'type_doc' => $this->request->getPost('tipo_documento'),
                'num_doc' => $this->request->getPost('numero_documento'),
                'registrar_id' => $session->id_user,
            ];
            // validar los datos
            $validation = \Config\Services::validation();
            $validation->setRules([
                'num_lab' => 'required|integer|max_length[2]',
                'type_doc' => 'required' ,
                'num_doc' => 'required|exact_length[8]',
            ]);
            if (!$validation->run($data)) {
                $session->setFlashdata('error', 'Los datos ingresados no son correctos');
                return redirect()->to(site_url('user/registerEntryLab'));
            }
            // obtener el ultimo registro de prestamo
            $model = model('PrestamosLabModel');
            $prestamo = $model->where('num_doc', $data['num_doc'])->where('type_doc', $data['type_doc'])->orderBy('hour_entry', 'DESC')->first();
            // verificar si existe un registro y si es del mismo dia
            if ($prestamo != null) {
                $date = date('Y-m-d', strtotime($prestamo['hour_entry']));
                $date_now = date('Y-m-d');
                if ($date == $date_now) {
                    if(date('H:i:s', strtotime($prestamo['hour_entry'])) == date('H:i:s', strtotime($prestamo['hour_exit']))){
                        // retornar error
                        $session->setFlashdata('error_num_doc', 'El usuario ya se encuentra registrado, por favor registre su salida');
                        return redirect()->to(site_url('user/registerEntryLab'));
                    }
                    $data['interval_num'] = $prestamo['interval_num'] + 1;
                } else {
                    $data['interval_num'] = 1;
                }
            } else {
                $data['interval_num'] = 1;
            }
            $prestamo = new PrestamosLab($data);
            $model->insert($prestamo);
            //registrar en el log
            $model_log = model('UserLogModel');
            $log = [
                'id_user' => $session->id_user,
                'action' => 'registro la entrada del usuario con el documento '.$data['num_doc'].' en el laboratorio '.$data['num_lab'],
            ];
            $model_log->insert($log);
            // retornar mensaje de exito
            $session->setFlashdata('success', 'El usuario se registro correctamente');
            return redirect()->to(site_url('user/registerEntryLab'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerExitLab()
    {
        $session = session();
        if ($session->isLoggedIn &&($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            return view('User/register_out_lab');
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerNewExitLab(){
        /**
         * Este método se encarga de registrar la salida de un usuario del laboratorio.
         * Verifica si el usuario está autenticado como administrador y si los datos ingresados son correctos.
         * Si el usuario ya tiene un registro de entrada en el laboratorio, actualiza la hora de salida.
         * Si el usuario no tiene un registro de entrada, muestra un mensaje de error.
         * @return redirect
         */
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $data = [
                'num_doc' => $this->request->getPost('num_doc'),
                'registrar_id' => $session->id_user,
            ];
            // validar los datos
            $validation = \Config\Services::validation();
            $validation->setRules([
                'num_doc' => 'required|exact_length[8]',
            ]);
            if (!$validation->run($data)) {
                $session->setFlashdata('error', 'Los datos ingresados no son correctos');
                return redirect()->to(site_url('user/registerExitLab'));
            }
            // obtener el ultimo registro de prestamo que la hora
            $model = model('PrestamosLabModel');
            $prestamo = $model->where('num_doc', $data['num_doc'])->orderBy('hour_entry', 'DESC')->first();
            // verificar si existe un registro y si es del mismo dia
            if ($prestamo != null) {
                $date = date('Y-m-d', strtotime($prestamo['hour_entry']));
                $date_now = date('Y-m-d');
                if ($date == $date_now && date('H:i:s', strtotime($prestamo['hour_entry'])) == date('H:i:s', strtotime($prestamo['hour_exit']))) {
                    //actualizar la hora de salida del prestamo
                    $prestamo['hour_exit'] = date('Y-m-d H:i:s');
                    $model->update($prestamo['id_prestamo'], $prestamo);
                    //registrar en el log
                    $model_log = model('UserLogModel');
                    $log = [
                        'id_user' => $session->id_user,
                        'action' => 'registro la salida del usuario con el documento '.$data['num_doc'].' en el laboratorio '.$prestamo['num_lab'],
                    ];
                    $model_log->insert($log);
                    // retornar mensaje de exito
                    $session->setFlashdata('success', 'El usuario se registro correctamente');
                    return redirect()->to(site_url('user/registerExitLab'));
                }else if($date != $date_now && date('H:i:s', strtotime($prestamo['hour_entry'])) == date('H:i:s', strtotime($prestamo['hour_exit']))){
                    // retornar error
                    $prestamo['hour_exit'] = date('Y-m-d H:i:s');
                    $model->update($prestamo['id_prestamo'], $prestamo);
                    // emviar mensaje de alerta
                    $session->setFlashdata('alert_num_doc', 'El usuario no se encuentra registrado el dia de hoy, recuerde al usuario recoger su carnet al salir');
                    return redirect()->to(site_url('user/registerExitLab'));
                }
                else{
                    // retornar error
                    $session->setFlashdata('error_num_doc', 'El usuario no se encuentra registrado, por favor registre su entrada');
                    return redirect()->to(site_url('user/registerExitLab'));
                }
            } else {
                $session->setFlashdata('error_num_doc', 'La entrada del usuario no se encuentra registrada');
                return redirect()->to(site_url('user/registerExitLab'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function viewRegisterEntryLab()
    {
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            // obtener todos los registros de entrada
            $model = model('PrestamosLabModel');
            $registerEntryLab = $model->getAllRegisterEntryLab();
            $data = [
                'registerEntryLab' => $registerEntryLab,
            ];
            if($registerEntryLab != null){
                foreach ($registerEntryLab as $key => $value) {
                    if(date('H:i:s', strtotime($value['hour_entry'])) == date('H:i:s', strtotime($value['hour_exit']))){
                        $data['registerEntryLab'][$key]['hour_exit'] = null;
                    }
                    if($value['type_doc'] == 1){
                        $data['registerEntryLab'][$key]['type_doc'] = 'DNI';
                    }
                    elseif($value['type_doc'] == 2){
                        $data['registerEntryLab'][$key]['type_doc'] = 'Carnet de biblioteca';
                    }
                    elseif($value['type_doc'] == 3){
                        $data['registerEntryLab'][$key]['type_doc'] = 'Carnet universitario';
                    }
                }
                return view('User/view_register_entry_lab', $data);
            }
            else{
                $session->setFlashdata('error', 'No se encontraron registros');
                return view('User/view_register_entry_lab', $data);
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function searchEntryLabByDocLab(){
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $data = [
                'type_doc' => $this->request->getPost('type_doc'),
                'num_lab' => $this->request->getPost('num_lab'),
            ];
            // validar los datos
            $validation = \Config\Services::validation();
            $validation->setRules([
                'type_doc' => 'required|integer|max_length[1]',
                'num_lab' => 'required|integer|max_length[2]',
            ]);
            if (!$validation->run($data)) {
                $session->setFlashdata('error', 'Los datos ingresados no son correctos');
                return redirect()->to(site_url('user/viewRegisterEntryLab'));
            }
            // obtener todos los registros de entrada
            $model = model('PrestamosLabModel');
            $registerEntryLab = $model->getByTypeDocLab($data['type_doc'], $data['num_lab']);
            $data = [
                'registerEntryLab' => $registerEntryLab,
            ];
            if($registerEntryLab != null){
                foreach ($registerEntryLab as $key => $value) {
                    if(date('H:i:s', strtotime($value['hour_entry'])) == date('H:i:s', strtotime($value['hour_exit']))){
                        $data['registerEntryLab'][$key]['hour_exit'] = null;
                    }
                    if($value['type_doc'] == 1){
                        $data['registerEntryLab'][$key]['type_doc'] = 'DNI';
                    }
                    elseif($value['type_doc'] == 2){
                        $data['registerEntryLab'][$key]['type_doc'] = 'Carnet de biblioteca';
                    }
                    elseif($value['type_doc'] == 3){
                        $data['registerEntryLab'][$key]['type_doc'] = 'Carnet universitario';
                    }
                }
                return view('User/view_register_entry_lab', $data);
            }
            else{
                $session->setFlashdata('error', 'No se encontraron registros');
                return redirect()->to(site_url('user/viewRegisterEntryLab'));
            }

 
        } else {
            return redirect()->to(site_url('login'));
        }
            
    }
    public function searchEntryLabByDatetime(){
        $session = session();
        if ($session->isLoggedIn && ($session->type == 'BOLSISTA' || $session->type == 'ADMINISTRADOR')) {
            $data = [
                'date_begin' => $this->request->getPost('date_begin'),
                'date_end' => $this->request->getPost('date_end'),
            ];
            // validar los datos
            $validation = \Config\Services::validation();
            $validation->setRules([
                'date_begin' => 'required',
                'date_end' => 'required',
            ]);
            if (!$validation->run($data)) {
                $session->setFlashdata('error', 'Los datos ingresados no son correctos');
                return redirect()->to(site_url('user/viewRegisterEntryLab'));
            }
            // obtener todos los registros de entrada
            $model = model('PrestamosLabModel');
            $data['date_end'] = date('Y-m-d', strtotime($data['date_end'] . ' +1 day'));
            //restarle -1 a date_begin
            $data['date_begin'] = date('Y-m-d', strtotime($data['date_begin'] . ' -1 day'));
            $registerEntryLab = $model->getByDatetime($data['date_begin'], $data['date_end']);
            $data = [
                'registerEntryLab' => $registerEntryLab,
            ];
            if($registerEntryLab != null){
                foreach ($registerEntryLab as $key => $value) {
                    if(date('H:i:s', strtotime($value['hour_entry'])) == date('H:i:s', strtotime($value['hour_exit']))){
                        $data['registerEntryLab'][$key]['hour_exit'] = null;
                    }
                    if($value['type_doc'] == 1){
                        $data['registerEntryLab'][$key]['type_doc'] = 'DNI';
                    }
                    elseif($value['type_doc'] == 2){
                        $data['registerEntryLab'][$key]['type_doc'] = 'Carnet de biblioteca';
                    }
                    elseif($value['type_doc'] == 3){
                        $data['registerEntryLab'][$key]['type_doc'] = 'Carnet universitario';
                    }
                }
                return view('User/view_register_entry_lab', $data);
            }
            else{
                $session->setFlashdata('error', 'No se encontraron registros');
                return redirect()->to(site_url('user/viewRegisterEntryLab'));
            }
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
                return redirect()->to(site_url('user/profile'));
            }
            $model = model('UserModel');
            $user = $model->getUserById($data['id_user']);
            if($user != null){
                if(password_verify($data['password'], $user['password'])){
                    $user['password'] = password_hash($data['newpassword'], PASSWORD_DEFAULT);
                    $model->update($user['id_user'], $user);
                    $session->setFlashdata('success', 'La contraseña se actualizo correctamente');
                    return redirect()->to(site_url('user/profile'));
                }
                else{
                    $session->setFlashdata('error', 'La contraseña actual es incorrecta');
                    return redirect()->to(site_url('user/profile'));
                }
            }
            else{
                $session->setFlashdata('error', 'El usuario no existe');
                return redirect()->to(site_url('user/profile'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
}

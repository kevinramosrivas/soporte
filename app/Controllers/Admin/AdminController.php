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
        if ($session->isLoggedIn && $session->type == 'admin') {
            //recolectar el numero de usuarios
            $user_model = model('UserModel');
            $users = $user_model->findAll();
            // obtener el numero de usuarios ocupando un laboratorio
            $prestamos_model = model('PrestamosLabModel');
            $users_lab = $prestamos_model->findAll();
            // que sean del dia de hoy
            foreach ($users_lab as $key => $value) {
                if($value['hour_entry'] !== $value['hour_exit'] && date('Y-m-d', strtotime($value['hour_entry'])) !== date('Y-m-d')){
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
    public function registerEntryLab()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            return view('Admin/register_entry_lab');
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
        if ($session->isLoggedIn && $session->type == 'admin') {
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
                'type_doc' => 'required|integer|max_length[1]',
                'num_doc' => 'required|exact_length[8]',
            ]);
            if (!$validation->run($data)) {
                $session->setFlashdata('error', 'Los datos ingresados no son correctos');
                return redirect()->to(site_url('admin/registerEntryLab'));
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
                        return redirect()->to(site_url('admin/registerEntryLab'));
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
            // retornar mensaje de exito
            $session->setFlashdata('success', 'El usuario se registro correctamente');
            return redirect()->to(site_url('admin/registerEntryLab'));
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
    public function registerNewExitLab(){
        /**
         * Este método se encarga de registrar la salida de un usuario del laboratorio.
         * Verifica si el usuario está autenticado como administrador y si los datos ingresados son correctos.
         * Si el usuario ya tiene un registro de entrada en el laboratorio, actualiza la hora de salida.
         * Si el usuario no tiene un registro de entrada, muestra un mensaje de error.
         * @return redirect
         */
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
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
                return redirect()->to(site_url('admin/registerExitLab'));
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
                    // retornar mensaje de exito
                    $session->setFlashdata('success', 'El usuario se registro correctamente');
                    return redirect()->to(site_url('admin/registerExitLab'));
                }else if($date != $date_now && date('H:i:s', strtotime($prestamo['hour_entry'])) == date('H:i:s', strtotime($prestamo['hour_exit']))){
                    // retornar error
                    $prestamo['hour_exit'] = date('Y-m-d H:i:s');
                    $model->update($prestamo['id_prestamo'], $prestamo);
                    // emviar mensaje de alerta
                    $session->setFlashdata('alert_num_doc', 'El usuario no se encuentra registrado el dia de hoy, recuerde al usuario recoger su carnet al salir');
                    return redirect()->to(site_url('admin/registerExitLab'));
                }
                else{
                    // retornar error
                    $session->setFlashdata('error_num_doc', 'El usuario no se encuentra registrado, por favor registre su entrada');
                    return redirect()->to(site_url('admin/registerExitLab'));
                }
            } else {
                $session->setFlashdata('error_num_doc', 'La entrada del usuario no se encuentra registrada');
                return redirect()->to(site_url('admin/registerExitLab'));
            }
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function viewRegisterEntryLab()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            // obtener todos los registros de entrada
            $model = model('PrestamosLabModel');
            $registerEntryLab = $model->getAllRegisterEntryLab();
            $data = [
                'registerEntryLab' => $registerEntryLab,
            ];
            // si la hora de entrada es igual a la hora de salida, el usuario no ha salido del laboratorio y se devuelve ese campo como null
            // si el valor de type_doc es 1, se muestra DNI
            // si el valor de type_doc es 2, se muestra Carnet de biblioteca
            // si el valor de type_doc es 3, se muestra Carnet universitario
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
            return view('Admin/view_register_entry_lab', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function searchEntryLabByDocLab(){
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
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
                return redirect()->to(site_url('admin/viewRegisterEntryLab'));
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
                return view('Admin/view_register_entry_lab', $data);
            }
            else{
                $session->setFlashdata('error', 'No se encontraron registros');
                return redirect()->to(site_url('admin/viewRegisterEntryLab'));
            }

 
        } else {
            return redirect()->to(site_url('login'));
        }
            
    }
    public function searchEntryLabByDatetime(){
        $session = session();
        if ($session->isLoggedIn && $session->type == 'admin') {
            $data = [
                'hour_entry' => $this->request->getPost('hour_entry'),
                'hour_exit' => $this->request->getPost('hour_exit'),
            ];
            // validar los datos
            $validation = \Config\Services::validation();
            $validation->setRules([
                'hour_entry' => 'required',
                'hour_exit' => 'required',
            ]);
            if (!$validation->run($data)) {
                $session->setFlashdata('error', 'Los datos ingresados no son correctos');
                return redirect()->to(site_url('admin/viewRegisterEntryLab'));
            }
            // obtener todos los registros de entrada
            $model = model('PrestamosLabModel');
            $registerEntryLab = $model->getByDatetime($data['hour_entry'], $data['hour_exit']);
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
                return view('Admin/view_register_entry_lab', $data);
            }
            else{
                $session->setFlashdata('error', 'No se encontraron registros');
                return redirect()->to(site_url('admin/viewRegisterEntryLab'));
            }
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
<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Entities\PrestamosLab;
use App\Models\PrestamosLabModel;

class UserController extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'user') {

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
            $data = [
                'students_in_lab' => $students_in_lab,
            ];
            return view('User/home', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerEntryLab()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'user') {
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
        if ($session->isLoggedIn && $session->type == 'user') {
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
        if ($session->isLoggedIn && $session->type == 'user') {
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
        if ($session->isLoggedIn && $session->type == 'user') {
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
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url('login'));
    }
}

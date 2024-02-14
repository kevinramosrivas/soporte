<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Helpers\VerifyAdmin;

class DashboardController extends BaseController
{
    public function indexAdmin()
    {
        /**
         * Verifica si el usuario ha iniciado sesión como administrador y muestra la vista de inicio del panel de administración.
         * Recopila el número total de usuarios y el número de usuarios que están ocupando un laboratorio en el día de hoy.
         * 
         * @return mixed
         */
        $session = session();
        //usar el helper para verificar si el usuario es administrador
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            //recolectamos los eventos recientes en user log
            $model = model('UserLogModel');
            $logs = $model->getAllLog();
            $model_user = model('UserModel');
            $users = count($model_user->getActiveUsers());
            $model_prestamos = model('PrestamosLabModel');
            $students_using_lab = count($model_prestamos->getStudentsUsingLab());
            //se calculo la diferencia entre la fecha actual y la fecha de creacion del registro
            $data = [
                'logs' => $logs,
                'now' => date('Y-m-d H:i:s'),
                'users' => $users,
                'students_using_lab' => $students_using_lab,
            ];
            return view('Admin/home', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function indexUser()
    {
        $session = session();
        if ($session->isLoggedIn && $session->type == 'BOLSISTA') {
            //recolectamos los eventos recientes en user log
            $model = model('UserLogModel');
            $logs = $model->getAllLog();
            $model_user = model('UserModel');
            $users = count($model_user->findAll());
            $model_prestamos = model('PrestamosLabModel');
            $students_using_lab = count($model_prestamos->getStudentsUsingLab());
            //se calculo la diferencia entre la fecha actual y la fecha de creacion del registro
            $data = [
                'logs' => $logs,
                'now' => date('Y-m-d H:i:s'),
                'users' => $users,
                'students_using_lab' => $students_using_lab,
            ];
            return view('Student/home', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
}
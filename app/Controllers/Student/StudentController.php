<?php
namespace App\Controllers\Student;
use App\Controllers\BaseController;
use App\Entities\User;


/**
 * Class LoginController
 * @package App\Controllers\Login
 */
class StudentController extends BaseController
{
    public function index()
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

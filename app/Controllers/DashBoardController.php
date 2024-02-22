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
            //obtenemos las tareas abiertas por semana
            $model_task = model('TaskModel');
            $numberOfTasksByState = $model_task->getNumberOfTasksByState();
            //obtenemos las tareas abiertas por usuario
            $task_open_user = $model_task->getTasksOpenByUser($session->id_user);
            $tasksOpenByUser = count(isset($task_open_user) ? $task_open_user : []);
            //obtenemos las tareas en proceso por usuario
            $task_in_process_user = $model_task->getTasksInProgressByUser($session->id_user);
            $tasksInProgressByUser = count(isset($task_in_process_user) ? $task_in_process_user : []);
            //obtenemos las tareas finalizadas por usuario
            $data = [
                'id_user' => $session->id_user,
                'date' => date('Y-m')
            ];
            $task_finished_user = $model_task->searchClosedTaskByDateAndUser($data);
            $taskFinishedByUser = count(isset($task_finished_user) ? $task_finished_user : []);
            $data = [
                'logs' => $logs,
                'now' => date('Y-m-d H:i:s'),
                'users' => $users,
                'students_using_lab' => $students_using_lab,
                'numberOfTasksByState' => $numberOfTasksByState ,
                'tasksOpenByUser' => $tasksOpenByUser,
                'tasksInProgressByUser' => $tasksInProgressByUser,
                'taskFinishedByUser' => $taskFinishedByUser
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
            $model_task = model('TaskModel');
            $numberOfTasksByState = $model_task->getNumberOfTasksByState();
            //obtenemos las tareas abiertas por usuario
            $task_open_user = $model_task->getTasksOpenByUser($session->id_user);
            $tasksOpenByUser = count(isset($task_open_user) ? $task_open_user : []);
            //obtenemos las tareas en proceso por usuario
            $task_in_process_user = $model_task->getTasksInProgressByUser($session->id_user);
            $tasksInProgressByUser = count(isset($task_in_process_user) ? $task_in_process_user : []);
            //obtenemos las tareas finalizadas por usuario
            $data = [
                'id_user' => $session->id_user,
                'date' => date('Y-m')
            ];
            $task_finished_user = $model_task->searchClosedTaskByDateAndUser($data);
            $taskFinishedByUser = count(isset($task_finished_user) ? $task_finished_user : []);
            $data = [
                'logs' => $logs,
                'now' => date('Y-m-d H:i:s'),
                'users' => $users,
                'students_using_lab' => $students_using_lab,
                'numberOfTasksByState' => $numberOfTasksByState ,
                'tasksOpenByUser' => $tasksOpenByUser,
                'tasksInProgressByUser' => $tasksInProgressByUser,
                'taskFinishedByUser' => $taskFinishedByUser
                
            ];
            return view('User/home', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
}
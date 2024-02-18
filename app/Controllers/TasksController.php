<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Entities\Task;
use App\Helpers\VerifyAdmin;
use App\Helpers\verifyUser;

class TasksController extends BaseController
{
    public function hola()
    {
        echo "hola";
    }
    public function tasks()
    {
        $session = session();
        $verify = verifyUser::verifyUser($session);
        if ($verify){
            //recuperar todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            //recuperar todas las tareas
            $model = model('TaskModel');
            $tasks_open = $model->getTasksOpen();
            $tasks_closed = $model->getTasksClosed();
            $tasks_in_progress = $model->getTasksInProgress();
            //separar en un array todos los usuarios de las tareas abiertas, ya que estos estan separados por comas
            foreach ($tasks_open as $task) {
                $task['username'] = explode(',', $task['username']);
            }

            $data = [
                'users' => $users,
                'tasks_open' => $tasks_open,
                'tasks_closed' => $tasks_closed,
                'tasks_in_progress' => $tasks_in_progress,
            ];
            return view('User/tasks', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function registerTask()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $model = model('TaskModel');
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'status' => 'open',
                'requesting_unit' => $this->request->getPost('requesting_unit'),
                'created_by' => $session->id_user,
                'assigned_to' => $this->request->getPost('assigned_to'),
            ];
            //usar la entidad para guardar los datos
            $task = new Task($data);
            $id_task = $model->insert($task);
            //importar el modelo task_user
            $model = model('TaskUserModel');
            if($id_task != null){
                //descomponer el array de usuarios recibido em assigned_to
                $assigned_to = $data['assigned_to'];
                //recorrer el array de usuarios y guardarlos en la tabla task_user
                foreach ($assigned_to as $id_user) {
                    $data = [
                        'id_task' => $id_task,
                        'id_user' => $id_user,
                    ];
                    $model->insert($data);
                }
            }
            return redirect()->to(site_url('tasks/tasks'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function editTask()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $model = model('TaskModel');
            $data = [
                'id_task' => $this->request->getPost('id_task'),
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'status' => $this->request->getPost('status'),
                'assigned_to' => $this->request->getPost('assigned_to'),
            ];
            $model->save($data);
            return redirect()->to(site_url('tasks/tasks'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function deleteTask()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $model = model('TaskModel');
            $model->delete($this->request->getPost('id_task'));
            return redirect()->to(site_url('tasks/tasks'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function searchTask()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $model = model('TaskModel');
            $data = [
                'id_task' => $this->request->getPost('id_task'),
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'status' => $this->request->getPost('status'),
                'created_by' => $this->request->getPost('created_by'),
                'assigned_to' => $this->request->getPost('assigned_to'),
                'followup_uuid_code' => $this->request->getPost('followup_uuid_code'),
            ];
            $tasks = $model->searchTask($data);
            $data = [
                'tasks' => $tasks,
            ];
            return view('Admin/tasks', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function restoreTask()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $model = model('TaskModel');
            $model->restore($this->request->getPost('id_task'));
            return redirect()->to(site_url('tasks/tasks'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
}

?>
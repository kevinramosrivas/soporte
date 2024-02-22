<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Entities\Task;
use App\Helpers\VerifyAdmin;
use App\Helpers\verifyUser;
use App\Entities\TaskComment;

class TasksController extends BaseController
{
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
    public function editTask($id_task)
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            //recuperar la información de la tarea de post
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'requesting_unit' => $this->request->getPost('requesting_unit'),
                'assigned_to' => $this->request->getPost('assigned_to'),
            ];
            //si el campo assigned_to no se recibe, solo se actualiza la tarea
            if($data['assigned_to'] == null){
                $model = model('TaskModel');
                $model->update($id_task, $data);
                return redirect()->to(site_url('tasks/tasks'));
            }
            //si el campo assigned_to se recibe, se actualiza la tarea y la tabla task_user
            //actualizar la tarea
            $model = model('TaskModel');
            $model->update($id_task, $data);
            //actualizar la tabla task_user
            $model = model('TaskUserModel');
            //borrar primero de la tabla task_user
            $model->where('id_task', $id_task)->delete();
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
            return redirect()->to(site_url('tasks/tasks'));

        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function deleteTask($id_task)
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            //borrar primero de la tabla task_user
            $model = model('TaskUserModel');
            $model->where('id_task', $id_task)->delete();
            $model = model('TaskModel');
            $model->delete($id_task);
            return redirect()->to(site_url('tasks/tasks'));
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function changeStatus($id_task)
    {
        $data = [
            'status' => $this->request->getPost('status'),
            'followup_uuid_code' => $this->request->getPost('followup_uuid_code'),
        ];
        //revisar que el status sea uno de los permitidos
        $allowed_status = ['open', 'in_progress', 'closed'];
        if(!in_array($data['status'], $allowed_status)){
            //retornar valor de 404
            return $this->response->setStatusCode(404);
        }
        $model = model('TaskModel');
        //ver si existe la tarea con el id recibido
        $task = $model->getTaskById($id_task);
        if($task != null){
            if($data['followup_uuid_code'] == $task['followup_uuid_code']){
                var_dump($data['followup_uuid_code']);
                var_dump($task['followup_uuid_code']);
                //quitar followup_uuid_code del array data
                unset($data['followup_uuid_code']);
                $model->update($id_task, $data);
                //retornar valor de 200
                return $this->response->setStatusCode(200);
            } else {
                //retornar valor de 404
                return $this->response->setStatusCode(404);
            }
        } else {
            //retornar valor de 404
            return $this->response->setStatusCode(404);
        }
    }
    public function closedTasks()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            //usar el metodo searchClosedTaskByDate con la fecha actual
            $model = model('TaskModel');
            $tasks = $model->searchClosedTaskByDate(['date' => date('Y-m')]);
            //recuperar todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            $data = [
                'tasks_closed' => $tasks,
                'users' => $users,
                'date' => date('Y-m'),
            ];
            return view('User/closed_tasks', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }

    public function myClosedTasks($id_user)
    {
        $session = session();
        $verify = VerifyUser::verifyUserAndUser($session, $id_user);
        if ($verify){
            $data = [
                'id_user' => $id_user,
                'date' => date('Y-m'),
            ];
            //recuperar todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            //recuperar todas las tareas cerradas
            $model = model('TaskModel');
            $tasks_closed = $model->searchClosedTaskByDateAndUser($data);
            $data = [
                'tasks_closed' => $tasks_closed,
                'users' => $users,
                'date' => date('Y-m'),
                'is_my_closed_tasks' => true,
            ];
            return view('User/closed_tasks', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function searchClosedTaskByDate()
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $data = [
                //separar el mes y el año de la fecha recibida
                'date' => $this->request->getPost('date'),

            ];
            //recuperar todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            //recuperar todas las tareas cerradas
            $model = model('TaskModel');
            $tasks = $model->searchClosedTaskByDate($data);
            $data = [
                'tasks_closed' => $tasks,
                'users' => $users,
                'date' => $data['date'],
            ];
            return view('User/closed_tasks', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function searchClosedTaskByDateAndUser(){
        $session = session();
        $verify = verifyUser::verifyUser($session);
        if ($verify){
            $data = [
                //separar el mes y el año de la fecha recibida
                'date' => $this->request->getPost('date'),
                'id_user' => $session->id_user,
            ];
            //recuperar todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            //recuperar todas las tareas cerradas
            $model = model('TaskModel');
            $tasks = $model->searchClosedTaskByDateAndUser($data);
            $data = [
                'tasks_closed' => $tasks,
                'users' => $users,
                'date' => $data['date'],
                'id_user' => $data['id_user'],
                'is_my_closed_tasks' => true,
            ];
            return view('User/closed_tasks', $data);
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
    /**
     * Retrieves the tasks for a specific user.
     *
     * @param int $id_user The ID of the user.
     * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface The view of the user's tasks or a redirect to the login page.
     */
    public function myTasks($id_user)
    {
        $session = session();
        $verify = verifyUser::verifyUserAndUser($session, $id_user);
        if ($verify){
            //recuperar todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            //recuperar todas las tareas
            $model = model('TaskModel');
            $tasks_open = $model->getTasksOpenByUser($id_user);
            $tasks_closed = $model->getTasksClosedByUser($id_user);
            $tasks_in_progress = $model->getTasksInProgressByUser($id_user);
            $is_admin_task = $session->type == 'ADMINISTRADOR';
            $data = [
                'tasks_open' => $tasks_open,
                'tasks_closed' => $tasks_closed,
                'tasks_in_progress' => $tasks_in_progress,
                'users' => $users,
                'is_admin_tasks' =>  $is_admin_task,
            ];
            return view('User/tasks', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }
    public function commentsTask($id_task, $uuid_code)
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            //recuperar todos la informacion de la tarea
            $model = model('TaskModel');
            $task = $model->getTaskAndUsersByID($id_task);
            //recuperar todos los usuarios
            $model = model('UserModel');
            $users = $model->findAll();
            //recuperar todos los comentarios de la tarea
            $model = model('TaskCommentModel');
            $comments = $model->getComments($id_task);
            $data = [
                'id_task' => $id_task,
                'uuid_code' => $uuid_code,
                'task' => $task,
                'users' => $users,
                'comments' => $comments,
            ];
            return view('User/comments_tasks', $data);
        } else {
            return redirect()->to(site_url('login'));
        }
    }

    public function registerComment($id_task, $uuid_code)
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $data = [
                'id_task' => $id_task,
                'created_by' => $session->id_user,
                'comment' => $this->request->getPost('comment'),
            ];
            $model = model('TaskCommentModel');
            //usar la entidad para guardar los datos
            $comment = new TaskComment($data);
            $model->insert($comment);
            return redirect()->to(site_url('tasks/comments/'.$id_task.'/'.$uuid_code));
        } else {
            return redirect()->to(site_url('login'));
        }
    }

    public function editComment($uuid_comment,$id_task, $uuid_code)
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $data = [
                'comment' => $this->request->getPost('comment'),
            ];
            //revisar que el campo comment no este vacio
            if($data['comment'] == null){
                return redirect()->to(site_url('tasks/comments/'.$id_task.'/'.$uuid_code));
            }
            $model = model('TaskCommentModel');
            $comment = new TaskComment($data);
            $model->update($uuid_comment, $comment);
            return redirect()->to(site_url('tasks/comments/'.$id_task.'/'.$uuid_code));
        } else {
            return redirect()->to(site_url('login'));
        }
    }

    public function deleteComment($uuid_comment,$id_task, $uuid_code)
    {
        $session = session();
        $verify = VerifyAdmin::verifyUser($session);
        if ($verify){
            $model = model('TaskCommentModel');
            $model->delete($uuid_comment);
            return redirect()->to(site_url('tasks/comments/'.$id_task.'/'.$uuid_code));
        } else {
            return redirect()->to(site_url('login'));
        }
    }

}

?>
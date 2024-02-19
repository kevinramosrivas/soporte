<?php

namespace App\Models;
use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id_task';
    protected $allowedFields = ['id_task','title', 'description', 'status', 'requesting_unit', 'created_by', 'followup_uuid_code', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function changeStatus($id_task, $status)
    {
        $task = $this->where('id_task', $id_task)->first();
        if($task != null){
            $task['status'] = $status;
            $result = $this->save($task);
            if($result){
                return true;
            }
        }
        return false;
    }


    public function getTasksOpen()
    {
        //obtener todas las tareas abiertas ordenadas por fecha de creación de forma descendente
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'open'
        GROUP BY tasks.id_task ORDER BY created_at DESC;
        ";
        $tasks = $this->query($sql)->getResultArray();        
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    public function getTasksClosed()
    {
        //limitar la cantidad de tareas cerradas a 10 y que sean las más recientes ordenadas por fecha de creación de forma descendente
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'closed'
        GROUP BY tasks.id_task ORDER BY created_at DESC LIMIT 10";
        $tasks = $this->query($sql)->getResultArray();        
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    public function getTasksInProgress()
    {
        //obtener todas las tareas en progreso
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'in_progress'
        GROUP BY tasks.id_task ORDER BY created_at DESC;
        ";
        $tasks = $this->query($sql)->getResultArray();        
        if($tasks != null){
            return $tasks;
        }
        return null;
    }


    public function searchTask($data)
    {
        $sql = "SELECT * FROM tasks WHERE ";
        $i = 0;
        foreach($data as $key => $value){
            if($value != null){
                if($i > 0){
                    $sql .= " AND ";
                }
                $sql .= "$key = '$value'";
                $i++;
            }
        }
        $tasks = $this->query($sql)->getResultArray();
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    public function getTaskById($id_task)
    {
        $task = $this->where('id_task', $id_task)->first();
        if($task != null){
            return $task;
        }
        return null;
    }
    public function getTaskByTitle($title)
    {
        $task = $this->where('title', $title)->first();
        if($task != null){
            return $task;
        }
        return null;
    }
    public function getTaskByDescription($description)
    {
        $task = $this->where('description', $description)->first();
        if($task != null){
            return $task;
        }
        return null;
    }
    public function getTaskByStatus($status)
    {
        $task = $this->where('status', $status)->first();
        if($task != null){
            return $task;
        }
        return null;
    }
    public function getTaskByRequestingUnit($requesting_unit)
    {
        $task = $this->where('requesting_unit', $requesting_unit)->first();
        if($task != null){
            return $task;
        }
        return null;
    }
    public function getTaskByCreatedBy($created_by)
    {
        $task = $this->where('created_by', $created_by)->first();
        if($task != null){
            return $task;
        }
        return null;
    }
    public function getTaskByAssignedTo($assigned_to)
    {
        $task = $this->where('assigned_to', $assigned_to)->first();
        if($task != null){
            return $task;
        }
        return null;
    }
    
}



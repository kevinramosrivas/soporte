<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Entities\Task;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id_task';
    protected $allowedFields = ['id_task','title', 'description', 'status', 'requesting_unit', 'created_by', 'followup_uuid_code', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getTaskByID($id_task)
    {
        $task = $this->where('id_task', $id_task)->first();
        if($task != null){
            return $task;
        }
        return null;
    }

    public function getTaskAndUsersByID($id_task)
    {
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username, GROUP_CONCAT(user.id_user) as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE tasks.id_task = ?
        GROUP BY tasks.id_task ORDER BY created_at ASC;
        ";
        $task = $this->query($sql, [$id_task])->getResultArray();
        if($task != null){
            return $task[0];
        }
        return null;
    }


    public function getTasksOpen()
    {
        //obtener todas las tareas abiertas ordenadas por fecha de creación de forma descendente
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username , GROUP_CONCAT(user.id_user) as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'open'
        GROUP BY tasks.id_task ORDER BY created_at ASC;
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
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username, GROUP_CONCAT(user.id_user) as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'closed'
        GROUP BY tasks.id_task ORDER BY created_at ASC LIMIT 5";
        $tasks = $this->query($sql)->getResultArray();        
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    public function getTasksInProgress()
    {
        //obtener todas las tareas en progreso
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username, GROUP_CONCAT(user.id_user) as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'in_progress'
        GROUP BY tasks.id_task ORDER BY created_at ASC;
        ";
        $tasks = $this->query($sql)->getResultArray();        
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    public function searchClosedTaskByDate($data)
    {
        //separar la fecha en mes y año
        $date = explode('-', $data['date']);
        $data['year'] = $date[0];
        $data['month'] = $date[1];
        //buscar tareas cerradas que se hayan actualizado el mes y año especificado
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username, GROUP_CONCAT(user.id_user) as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'closed' AND YEAR(tasks.updated_at) = ? AND MONTH(tasks.updated_at) = ?
        GROUP BY tasks.id_task ORDER BY created_at ASC;
        ";
        $tasks = $this->query($sql, [$data['year'], $data['month']])->getResultArray();
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    public function getTasksOpenByUser($id_user)
    {
        //obtener todas las tareas abiertas asignadas a un usuario se pasa el uuid del usuario
        $sql = "SELECT tasks.*, user.username as username, user.id_user as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'open' AND task_user.id_user = ?
        GROUP BY tasks.id_task ORDER BY created_at ASC;
        ";
        $tasks = $this->query($sql, [$id_user])->getResultArray();
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    
    public function getTasksInProgressByUser($id_user)
    {
        //obtener todas las tareas en progreso asignadas a un usuario se pasa el id del usuario
        $sql = "SELECT tasks.*, user.username as username, user.id_user as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'in_progress' AND task_user.id_user = ?
        GROUP BY tasks.id_task ORDER BY created_at ASC;
        ";
        $tasks = $this->query($sql, [$id_user])->getResultArray();
        if($tasks != null){
            return $tasks;
        }
        return null;
    }

    public function getTasksClosedByUser($id_user)
    {
        //obtener todas las tareas cerradas asignadas a un usuario se pasa el uuid del usuario
        $sql = "SELECT tasks.*, user.username as username, user.id_user as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'closed' AND task_user.id_user = ?
        GROUP BY tasks.id_task ORDER BY created_at ASC LIMIT 10;
        ";
        $tasks = $this->query($sql, [$id_user])->getResultArray();
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    public function searchClosedTaskByDateAndUser($data)
    {
        //separar la fecha en mes y año
        $date = explode('-', $data['date']);
        $data['year'] = $date[0];
        $data['month'] = $date[1];
        //buscar tareas cerradas que se hayan actualizado el mes y año especificado y que estén asignadas a un usuario
        $sql = "SELECT tasks.*, GROUP_CONCAT(user.username) as username, GROUP_CONCAT(user.id_user) as id_users
        FROM tasks
        INNER JOIN task_user ON tasks.id_task = task_user.id_task
        LEFT JOIN user ON task_user.id_user = user.id_user
        WHERE status = 'closed' AND YEAR(tasks.updated_at) = ? AND MONTH(tasks.updated_at) = ? AND task_user.id_user = ?
        GROUP BY tasks.id_task ORDER BY created_at ASC;
        ";
        $tasks = $this->query($sql, [$data['year'], $data['month'], $data['id_user']])->getResultArray();
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

    //obtener el numero de tareas abiertas
    public function getNumberOfOpenTasks()
    {
        $sql = "SELECT COUNT(*) as number FROM tasks WHERE status = 'open'";
        $number = $this->query($sql)->getResultArray();
        if($number != null){
            return $number[0]['number'];
        }
        return 0;
    }

    //obtener el numero de tareas cerradas
    public function getNumberOfClosedTasks()
    {
        $sql = "SELECT COUNT(*) as number FROM tasks WHERE status = 'closed'";
        $number = $this->query($sql)->getResultArray();
        if($number != null){
            return $number[0]['number'];
        }
        return 0;
    }


    //obtener el numero de tareas en progreso
    public function getNumberOfInProgressTasks()
    {
        $sql = "SELECT COUNT(*) as number FROM tasks WHERE status = 'in_progress'";
        $number = $this->query($sql)->getResultArray();
        if($number != null){
            return $number[0]['number'];
        }
        return 0;
    }

    //obtener el numero de tareas por dia de la semana, en caso en algun dia no existan tareas se debe mostrar 0
    public function getOpenTasksByWeek()
    {
        $sql = "SELECT all_days.day_of_week, IFNULL(task_count.number, 0) as number
        FROM (
            SELECT 1 AS day_of_week UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
        ) AS all_days
        LEFT JOIN (
            SELECT DAYOFWEEK(created_at) as day, COUNT(*) as number
            FROM tasks
            WHERE YEARWEEK(created_at) = YEARWEEK(NOW()) AND status = 'open'
            GROUP BY DAYOFWEEK(created_at)
        ) AS task_count
        ON all_days.day_of_week = task_count.day
        ORDER BY all_days.day_of_week; ";

        $tasks = $this->query($sql)->getResultArray();
        if($tasks != null){
            return $tasks;
        }
    }


    //obtener el nombre del dia de la semana, la semana debe ser la actual para las tareas en progreso
    public function getInProgressTasksByWeek()
    {
        $sql = "SELECT all_days.day_of_week, IFNULL(task_count.number, 0) as number
        FROM (
            SELECT 1 AS day_of_week UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
        ) AS all_days
        LEFT JOIN (
            SELECT DAYOFWEEK(created_at) as day, COUNT(*) as number
            FROM tasks
            WHERE YEARWEEK(created_at) = YEARWEEK(NOW()) AND status = 'in_progress'
            GROUP BY DAYOFWEEK(created_at)
        ) AS task_count
        ON all_days.day_of_week = task_count.day
        ORDER BY all_days.day_of_week; ";
        $tasks = $this->query($sql)->getResultArray();
        if($tasks != null){
            return $tasks;
        }
        return null;
    }

    public function getClosedTasksByWeek()
    {
        $sql = "SELECT all_days.day_of_week, IFNULL(task_count.number, 0) as number
        FROM (
            SELECT 1 AS day_of_week UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
        ) AS all_days
        LEFT JOIN (
            SELECT DAYOFWEEK(created_at) as day, COUNT(*) as number
            FROM tasks
            WHERE YEARWEEK(created_at) = YEARWEEK(NOW()) AND status = 'closed'
            GROUP BY DAYOFWEEK(created_at)
        ) AS task_count
        ON all_days.day_of_week = task_count.day
        ORDER BY all_days.day_of_week; ";
        $tasks = $this->query($sql)->getResultArray();
        if($tasks != null){
            return $tasks;
        }
        return null;
    }
    //obtener el numero de tareas open,in_progress y closed , si no existen tareas de algun tipo se debe mostrar 0
    //por ejemplo open, in_progress, closed
    //0,1,4
    public function getNumberOfTasksByState()
    {
        $sql = "SELECT COUNT(*) as number, status
        FROM tasks
        WHERE YEARWEEK(created_at) = YEARWEEK(NOW())
        GROUP BY status";
        $tasks = $this->query($sql)->getResultArray();
        if($tasks != null){
            //devolver en un array asociativo el numero de tareas por estado
            $status = ['open' => 0, 'in_progress' => 0, 'closed' => 0];
            foreach($tasks as $task){
                $status[$task['status']] = $task['number'];
            }
            return $status;
        }
        return null;        
    }
    
}



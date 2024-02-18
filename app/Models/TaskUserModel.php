<?php

namespace App\Models;
use CodeIgniter\Model;

class TaskUserModel extends Model
{
    protected $table = 'task_user';
    protected $primaryKey = 'id_task_user';
    protected $returnType = 'array';
    protected $allowedFields = ['id_task', 'id_user'];


    public function getTaskUser($id_task)
    {
        $task_user = $this->where('id_task', $id_task)->findAll();
        if($task_user != null){
            return $task_user;
        }
        return null;
    }
    public function getUserTask($id_user)
    {
        $user_task = $this->where('id_user', $id_user)->findAll();
        if($user_task != null){
            return $user_task;
        }
        return null;
    }
}
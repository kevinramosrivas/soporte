<?php

namespace App\Models;
use CodeIgniter\Model;

class TaskCommentModel extends Model
{
    protected $table = 'task_comments';
    protected $primaryKey = 'id_comment_uuid';
    protected $allowedFields = ['id_comment_uuid', 'id_task', 'comment', 'created_by', 'created_at', 'updated_at'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getComments($id_task)
    {
        //obtener los datos de la tabla task_comments y la tabla users
        return $this->select('task_comments.id_comment_uuid, task_comments.id_task, task_comments.comment, task_comments.created_by, task_comments.created_at, task_comments.updated_at, user.id_user_uuid, user.username, user.email')
            ->join('user', 'task_comments.created_by = user.id_user')
            ->where('id_task', $id_task)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    public function saveComment($data)
    {
        return $this->save($data);
    }

    

}
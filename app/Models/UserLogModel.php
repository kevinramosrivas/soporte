<?php

namespace App\Models;
use CodeIgniter\Model;

class UserLogModel extends Model
{
    protected $table = 'users_log';
    protected $primaryKey = 'id_log';
    protected $allowedFields = ['id_log','id_user', 'action', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    
    public function getAllLog()
    {
        $sql = "SELECT users_log.id_log, users_log.id_user, users_log.action, users_log.created_at, users_log.updated_at, user.username
        FROM users_log JOIN user ON users_log.id_user = user.id_user ORDER BY users_log.created_at DESC LIMIT 20 ";
        $log = $this->query($sql)->getResultArray();
        if($log != null){
            return $log;
        }
        return null;
    }
    public function getLogById($id_log)
    {
        $log = $this->where('id_log', $id_log)->first();
        if($log != null){
            return $log;
        }
        return null;
    }
    public function getLogByUserId($id_user)
    {
        $log = $this->where('id_user', $id_user)->first();
        if($log != null){
            return $log;
        }
        return null;
    }
    public function getLogByAction($action)
    {
        $log = $this->where('action', $action)->first();
        if($log != null){
            return $log;
        }
        return null;
    }
    public function getLogByDatetime($created_at, $updated_at)
    {
        if($created_at == null && $updated_at == null){
            return $this->getAllLog();
        }
        if($created_at == null){
            $log = $this->query("SELECT * FROM user_log WHERE updated_at = $updated_at")->getResultArray();
            if($log != null){
                return $log;
            }
            return null;
        }
        if($updated_at == null){
            $log = $this->query("SELECT * FROM user_log WHERE created_at = $created_at")->getResultArray();
            if($log != null){
                return $log;
            }
            return null;
        }
        $log = $this->query("SELECT * FROM user_log WHERE created_at = $created_at AND updated_at = $updated_at")->getResultArray();   
        if($log != null){
            return $log;
        }
    }
    public function getLogByDatetimeAndAction($created_at, $updated_at, $action)
    {
        if($created_at == null && $updated_at == null && $action == null){
            return $this->getAllLog();
        }
        if($created_at == null && $updated_at == null){
            $log = $this->query("SELECT * FROM user_log WHERE action = $action")->getResultArray();
            if($log != null){
                return $log;
            }
            return null;
        }
        if($created_at == null && $action == null){
            $log = $this->query("SELECT * FROM user_log WHERE updated_at = $updated_at")->getResultArray();
            if($log != null){
                return $log;
            }
            return null;
        }
        if($updated_at == null && $action == null){
            $log = $this->query("SELECT * FROM user_log WHERE created_at = $created_at")->getResultArray();
            if($log != null){
                return $log;
            }
            return null;
        }
        if($created_at == null){
            $log = $this->query("SELECT * FROM user_log WHERE updated_at = $updated_at AND action = $action")->getResultArray();
            if($log != null){
                return $log;
            }
            return null;
        }
        if($updated_at == null){
            $log = $this->query("SELECT * FROM user_log WHERE created_at = $created_at AND action = $action")->getResultArray();
            if($log != null){
                return $log;
            }
            return null;
        }
        if($action == null){
            $log = $this->query("SELECT * FROM user_log WHERE created_at = $created_at AND updated_at = $updated_at")->getResultArray();
            if($log != null){
                return $log;
            }
            return null;
        }
        $log = $this->query("SELECT * FROM user_log WHERE created_at = $created_at AND updated_at = $updated_at AND action = $action")->getResultArray();
        if($log != null){
            return $log;
        }
        return null;
    }

}
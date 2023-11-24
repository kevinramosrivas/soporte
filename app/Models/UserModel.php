<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['type', 'username', 'email', 'password', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function getUser($email, $password)
    {
        $user = $this->where('email', $email)->first();
        if($user != null){
            if(password_verify($password, $user['password'])){
                return $user;
            }
        }
        return null;
    }
    public function getUserByEmail($email)
    {
        $user = $this->where('email', $email)->first();
        if($user != null){
            return $user;
        }
        return null;
    }
    public function searchUser($search)
    {
        $user = $this->query("SELECT * FROM user WHERE username LIKE '%$search%' OR email LIKE '%$search%'")->getResultArray();
        if($user != null){
            return $user;
        }
        return null;
    }
    public function desactivateUser($id)
    {
        $user = $this->where('id_user', $id)->first();
        if($user != null){
            $this->query("UPDATE user SET active = 0 WHERE id_user = '$id'");
            return true;
        }
        return false;
    }
    public function updateUser($id, $data)
    {
        $user = $this->where('id_user', $id)->first();
        //obtener datetime actual
        $date = date('Y-m-d H:i:s');
        if($user != null && $data['password'] != null){
            $this->query("UPDATE user SET type = '$data[type]', 
            username = '$data[username]', 
            email = '$data[email]', 
            password = '$data[password]', 
            active = '$data[active]' 
            , updated_at = '$date'
            WHERE id_user = '$id'");
            return true;
        }
        if($user != null && $data['password'] == null){
            $this->query("UPDATE user SET type = '$data[type]', 
            username = '$data[username]', 
            email = '$data[email]', 
            active = '$data[active]' 
            , updated_at = '$date'
            WHERE id_user = '$id'");
            return true;
        }
        return false;
    }

}
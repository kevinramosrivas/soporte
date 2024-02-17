<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['id_user','type', 'username', 'email', 'password', 'user_status', 'created_at', 'updated_at'];
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
    public function getUserById($id)
    {
        $user = $this->where('id_user', $id)->first();
        if($user != null){
            return $user;
        }
        return null;
    }
    public function searchUser($search)
    {

        $search = $this->escapeLikeString($search);
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
            $sql = "UPDATE user SET user_status = :user_status: WHERE id_user = :id:";
            $this->query($sql, ['user_status' => 0, 'id' => $id]);
            return true;
        }
        return false;
    }
    public function activateUser($id)
    {
        $user = $this->where('id_user', $id)->first();
        if($user != null){
            $sql = "UPDATE user SET user_status = :user_status: WHERE id_user = :id:";
            $this->query($sql, ['user_status' => 1, 'id' => $id]);
            return true;
        }
        return false;
    }

    public function getInactiveUsers()
    {
        $user = $this->where('user_status', 0)->findAll();
        if($user != null){
            return $user;
        }
        return null;
    }
    public function getActiveUsers()
    {
        $user = $this->where('user_status', 1)->findAll();
        if($user != null){
            return $user;
        }
        return null;
    }
    

}
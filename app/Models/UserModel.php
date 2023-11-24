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
        //return null;
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
            $sql = "UPDATE user SET active = :active: WHERE id_user = :id:";
            $this->query($sql, ['active' => 0, 'id' => $id]);
            return true;
        }
        return false;
    }
    public function updateUser($id, $data)
    {
        $user = $this->where('id_user', $id)->first();
        //obtener datetime actual
        $date = date('Y-m-d H:i:s');
        $sql_with_password = "UPDATE user SET type = :type:,
        username = :username:,
        email = :email:,
        password = :password:,
        active = :active:,
        updated_at = :updated_at:
        WHERE id_user = :id:";
        if($user != null && $data['password'] != null){
            $this->query($sql_with_password, 
            ['type' => $data['type'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'active' => $data['active'],
            'updated_at' => $date,
            'id' => $id]);
            return true;
        }
        $sql_without_password = "UPDATE user SET type = :type:,
        username = :username:,
        email = :email:,
        active = :active:,
        updated_at = :updated_at:
        WHERE id_user = :id:";
        if($user != null && $data['password'] == null){
            $this->query($sql_without_password, 
            ['type' => $data['type'],
            'username' => $data['username'],
            'email' => $data['email'],
            'active' => $data['active'],
            'updated_at' => $date,
            'id' => $id]);
            return true;
        }
        return false;
    }

}
<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Helpers\Encryptor;

class PasswordsModel extends Model
{
    protected $table = 'passwords';
    protected $primaryKey = 'id_password';
    protected $allowedFields = ['typeAccount', 'accountName', 'username', 'password', 'level','registrar_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $encryptor;

    public function __construct()
    {
        parent::__construct();
        $this->encryptor = Encryptor::getInstance();
    }

    public function getPasswords($typeUser)
    {
        if ($typeUser == 'ADMINISTRADOR') {
            //desencriptar datos antes de retornarlos
            $passwords = $this->findAll();
            $passwords = array_map(function ($password) {
                $password['accountName'] = $this->encryptor->decrypt($password['accountName']);
                $password['username'] = $this->encryptor->decrypt($password['username']);
                $password['password'] = $this->encryptor->decrypt($password['password']);
                return $password;
            }, $passwords);
            return $passwords;
        } elseif ($typeUser == 'BOLSISTA') {
            $passwords = $this->where('level', 'BOLSISTA')->findAll();
            $passwords = array_map(function ($password) {
                $password['accountName'] = $this->encryptor->decrypt($password['accountName']);
                $password['username'] = $this->encryptor->decrypt($password['username']);
                $password['password'] = $this->encryptor->decrypt($password['password']);
                return $password;
            }, $passwords);
            return $passwords;
        }
        return null;
    }
    public function getPasswordById($id)
    {
        $password = $this->find($id);
        //desencriptar datos antes de retornarlos
        $password['accountName'] = $this->encryptor->decrypt($password['accountName']);
        $password['username'] = $this->encryptor->decrypt($password['username']);
        $password['password'] = $this->encryptor->decrypt($password['password']);
        return $password;
    }

}
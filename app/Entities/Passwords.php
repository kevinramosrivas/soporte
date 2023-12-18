<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Helpers\Encryptor;






class Passwords extends Entity
{
    protected $datamap = ['id_password','typeAccount', 'accountName', 'username', 'password', 'registrar_id', 'created_at', 'updated_at'];
    protected $dates   = ['created_at', 'updated_at'];
    protected $allowedFields = ['typeAccount', 'accountName', 'username', 'password', 'registrar_id', 'level','created_at', 'updated_at'];
    protected $casts   = [];
    protected $encryptor;

    public function __construct($data)
    {
        $this->encryptor = Encryptor::getInstance();
        $this->fill($data);
        $this->encryptAccountName($this->attributes['accountName']);
        $this->encryptUsername($this->attributes['username']);
        $this->encryptPassword($this->attributes['password']);

    }



    protected function encryptAccountName(string $accountName)
    {
        $this->attributes['accountName'] = $this->encryptor->encrypt($accountName);
        
    }

    protected function encryptUsername(string $username)
    {
        $this->attributes['username'] =  $this->encryptor->encrypt($username);
    }

    protected function encryptPassword(string $password)
    {
        $this->attributes['password'] = $this->encryptor->encrypt($password);
    }



}
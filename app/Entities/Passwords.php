<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Helpers\Encryptor;
use App\Libraries\Uuid;






class Passwords extends Entity
{
    protected $datamap = ['id_password','typeAccount', 'accountName', 'username', 'password', 'registrar_id', 'level','additionalInfo','created_at', 'updated_at'];
    protected $dates   = ['created_at', 'updated_at'];
    protected $allowedFields = ['typeAccount', 'accountName', 'username', 'password', 'registrar_id', 'level','additionalInfo','created_at', 'updated_at'];
    protected $casts   = [];
    protected $encryptor;

    public function __construct($data)
    {
        $this->encryptor = Encryptor::getInstance();
        $this->fill($data);
        $this->encryptAccountName($this->attributes['accountName']);
        $this->encryptUsername($this->attributes['username']);
        $this->encryptPassword($this->attributes['password']);
        $this->encryptAdditionalInfo($this->attributes['additionalInfo']);
        $this->setUUID();

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
    protected function encryptAdditionalInfo(string $additionalInfo)
    {
        $this->attributes['additionalInfo'] = $this->encryptor->encrypt($additionalInfo);
    }

    protected function setUUID()
    {
        $uuid = new Uuid();
        $this->attributes['id_password'] = $uuid->v4();
    }



}
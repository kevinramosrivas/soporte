<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
helper('date');



class Passwords extends Entity
{
    protected $datamap = ['id_password','typeAccount', 'accountName', 'username', 'password', 'registrar_id', 'created_at', 'updated_at'];
    protected $dates   = ['created_at', 'updated_at'];
    
    protected $casts   = [];
    // Define the secret key
    protected $key = "secret";

    // Define the encryption method
    protected $method = "AES-256-CBC";

    protected $separator = ':';
    
    protected function encryptText($text, $key) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($text, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    protected function setCreatedAt()
    {
        $this->attributes['created_at'] = now('America/Los_Angeles', 'datetime');
    }

    protected function setUpdatedAt()
    {
        $this->attributes['updated_at'] = now('America/Los_Angeles', 'datetime');
    }

    public function encryptAccountName(string $accountName)
    {
        $this->attributes['accountName'] = $this->encryptText($accountName, $this->key);
        
    }

    public function encryptUsername(string $username)
    {
        $this->attributes['username'] = $this->encryptText($username, $this->key);
    }

    public function encryptPassword(string $password)
    {
        $this->attributes['password'] = $this->encryptText($password, $this->key);
    }



}
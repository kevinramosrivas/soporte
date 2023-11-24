<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
helper('date');

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function encriptPassword(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    protected function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }
    protected function setUsername(string $username)
    {
        $this->attributes['username'] = strtoupper($username);
    }
    protected function setCreatedAt()
    {
        $this->attributes['created_at'] = now('America/Los_Angeles', 'datetime');
    }
    protected function setUpdatedAt()
    {
        $this->attributes['updated_at'] = now('America/Los_Angeles', 'datetime');
    }
}

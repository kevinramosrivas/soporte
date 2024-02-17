<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Uuid;
helper('date');

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    //ejectuar el metodo para crear un id unico cuando se cree un nuevo objeto de la clase
    public function __construct(array $data = null)
    {
        parent::__construct($data);
        $this->setUUID();
    }

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

    protected function setUUID()
    {
        $uuid = new Uuid();
        $this->attributes['id_user'] = $uuid->v4();
    }
}

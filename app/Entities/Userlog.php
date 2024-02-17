<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Uuid;
helper('date');

class UserLog extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];


    public function __construct(array $data = null)
    {
        parent::__construct($data);
        $this->setUUID();
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
        $this->attributes['id_log'] = $uuid->v4();
    }


}
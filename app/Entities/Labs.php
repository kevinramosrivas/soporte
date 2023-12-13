<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
helper('date');

class Labs extends Entity
{
    protected $datamap = ['id_lab','num_laboratorio', 'capacity_max', 'created_at', 'updated_at'];
    protected $dates   = ['created_at'];
    protected $casts   = [];

    protected function setCreatedAt()
    {
        $this->attributes['created_at'] = now('America/Los_Angeles', 'datetime');
    }

    protected function setUpdatedAt()
    {
        $this->attributes['updated_at'] = now('America/Los_Angeles', 'datetime');
    }
}
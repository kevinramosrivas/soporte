<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
helper('date');

class Labs extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at'];
    protected $casts   = [];

    protected function setCreatedAt()
    {
        $this->attributes['created_at'] = now('America/Los_Angeles', 'datetime');
    }
}
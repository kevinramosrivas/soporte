<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
helper('date');


class Thing extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'returned_at'];
    protected $casts   = [];

    protected function setCreatedAt()
    {
        $this->attributes['created_at'] = now('America/Los_Angeles', 'datetime');
    }
    protected function setReturnedAt()
    {
        $this->attributes['returned_at'] = now('America/Los_Angeles', 'datetime');
    }
}
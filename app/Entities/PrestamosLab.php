<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
helper('date');


class PrestamosLab extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'hour_entry', 'hour_exit'];
    protected $casts   = [];

    protected function setCreatedAt()
    {
        $this->attributes['created_at'] = now('America/Los_Angeles', 'datetime');
    }
    protected function setHourEntry()
    {
        $this->attributes['hour_entry'] = now('America/Los_Angeles', 'datetime');
    }
    protected function setHourExit()
    {
        $this->attributes['hour_exit'] = now('America/Los_Angeles', 'datetime');
    }
}
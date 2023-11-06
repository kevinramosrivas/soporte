<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
helper('date');


class PrestamosLab extends Entity
{
    protected $datamap = [];
    protected $dates   = ['hour_entry', 'hour_exit'];
    protected $casts   = [];

    public function setHourEntry()
    {
        $this->attributes['hour_entry'] = now('America/Los_Angeles', 'datetime');
    }
    public function setHourExit()
    {
        $this->attributes['hour_exit'] = now('America/Los_Angeles', 'datetime');
    }
}
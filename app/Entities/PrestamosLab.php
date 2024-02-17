<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Uuid;
helper('date');


class PrestamosLab extends Entity
{
    protected $datamap = ['id_prestamo','num_lab', 'num_doc', 'type_doc', 'hour_entry', 'hour_exit', 'interval_num', 'registrar_id'];
    protected $dates   = ['hour_entry', 'hour_exit'];
    protected $casts   = [];
    //ejectuar el metodo para crear un id unico cuando se cree un nuevo objeto de la clase
    public function __construct(array $data = null)
    {
        parent::__construct($data);
        $this->generateUUID();
    }

    //crear un id unico para el prestamo
    protected function generateUUID()
    {
        $uuid = new Uuid();
        $this->attributes['id_prestamo'] = $uuid->v4();
    }

    public function setHourEntry()
    {
        $this->attributes['hour_entry'] = now('America/Los_Angeles', 'datetime');
    }
    public function setHourExit()
    {
        $this->attributes['hour_exit'] = now('America/Los_Angeles', 'datetime');
    }
}
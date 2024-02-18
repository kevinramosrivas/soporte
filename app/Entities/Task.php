<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Uuid;






class Task extends Entity
{
    protected $datamap = ['id_task', 'title', 'description', 'status', 'requesting_unit', 'created_by', 'assigned_to', 'followup_uuid_code', 'created_at', 'updated_at'];


    //constructor
    public function __construct(array $data = null)
    {
        parent::__construct($data);
        $this->setFollowupUuidCode();
        $this->getAssignedTo();
    }
    //funcion que concatene los valores del array de assigned_to
    private function getAssignedTo()
    {
        $this->attributes['assigned_to'] = implode(',', $this->attributes['assigned_to']);
        return $this;
    }
    private function setFollowupUuidCode()
    {
        $uuid = new Uuid();
        $this->attributes['followup_uuid_code'] = $uuid->v4();
        return $this;
    }

}


<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Uuid;






class TaskComment extends Entity
{
    protected $datamap = ['id_comment_uuid' => 'id_comment_uuid', 'id_task' => 'id_task', 'comment' => 'comment', 'created_by' => 'created_by', 'created_at' => 'created_at', 'updated_at' => 'updated_at'];


    //constructor
    public function __construct(array $data = null)
    {
        parent::__construct($data);
        $this->setFollowupUuidCode();
    }
    private function setFollowupUuidCode()
    {
        $uuid = new Uuid();
        $this->attributes['id_comment_uuid'] = $uuid->v4();
        return $this;
    }

}
<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Uuid;





class Categories extends Entity
{
    protected $datamap = ['id_category','id_category_uuid', 'categoryName', 'categoryDescription', 'created_at', 'updated_at'];
    protected $dates   = ['created_at', 'updated_at'];
    protected $allowedFields = ['id_category','id_category_uuid', 'categoryName', 'categoryDescription', 'created_at', 'updated_at'];
    protected $casts   = [];

    public function __construct($data)
    {
        $this->fill($data);
        $this->setUUID();
    }

    public function setCategoryName(string $name)
    {
        $this->attributes['categoryName'] = $name;
        return $this;
    }

    public function setCategoryDescription(string $description)
    {
        $this->attributes['categoryDescription'] = $description;
        return $this;
    }

    public function setRegistrarId(string $id)
    {
        $this->attributes['registrar_id'] = $id;
        return $this;
    }

    protected function setUUID()
    {
        $uuid = new Uuid();
        $this->attributes['id_category_uuid'] = $uuid->v4();
    }
    
}

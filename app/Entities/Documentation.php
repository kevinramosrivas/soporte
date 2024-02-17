<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Uuid;





class Documentation extends Entity
{
    protected $datamap = ['id_document', 'id_category', 'documentName', 'documentDescription', 'documentPath', 'registrar_id', 'created_at', 'updated_at'];
    protected $dates   = ['created_at', 'updated_at'];
    protected $allowedFields = ['id_document', 'id_category', 'documentName', 'documentDescription', 'documentPath', 'registrar_id', 'created_at', 'updated_at'];
    protected $casts   = [];

    public function __construct($data)
    {
        $this->fill($data);
        $this->setUUID();
    }

    public function setDocumentName(string $name)
    {
        $this->attributes['documentName'] = $name;
        return $this;
    }

    public function setDocumentDescription(string $description)
    {
        $this->attributes['documentDescription'] = $description;
        return $this;
    }

    public function setDocumentPath(string $path)
    {
        $this->attributes['documentPath'] = $path;
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
        $this->attributes['id_document'] = $uuid->v4();
    }
    
}

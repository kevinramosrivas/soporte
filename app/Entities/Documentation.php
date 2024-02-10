<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;






class Documentation extends Entity
{
    protected $datamap = ['id_documentation','id_document', 'id_category', 'documentName', 'documentDescription', 'documentPath', 'registrar_id', 'created_at', 'updated_at'];
    protected $dates   = ['created_at', 'updated_at'];
    protected $allowedFields = ['id_document', 'id_category', 'documentName', 'documentDescription', 'documentPath', 'registrar_id', 'created_at', 'updated_at'];
    protected $casts   = [];

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

    public function setRegistrarId(int $id)
    {
        $this->attributes['registrar_id'] = $id;
        return $this;
    }
    
}

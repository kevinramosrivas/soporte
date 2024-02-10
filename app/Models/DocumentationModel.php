<?php

namespace App\Models;
use CodeIgniter\Model;

class DocumentationModel extends Model
{
    protected $table = 'documentation';
    protected $primaryKey = 'id_documentation';
    protected $allowedFields = ['id_document', 'id_category', 'documentName', 'documentDescription', 'documentPath', 'registrar_id', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function saveDocumentation($data)
    {
        $this->insert($data);
        return $this->insertID();
    }





}
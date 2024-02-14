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
    }

    public function getDocuments()
    {
        //hacer un join con la tabla de categorias, la consulta sera una consulta preparada
        $sql = "SELECT d.id_document, d.documentName, c.categoryName ,d.documentDescription, d.documentPath, d.created_at, d.updated_at
        FROM documentation d INNER JOIN documentation_categories c ON d.id_category = c.id_category";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }





}
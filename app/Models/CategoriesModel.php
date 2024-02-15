<?php

namespace App\Models;
use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table = 'documentation_categories';
    protected $primaryKey = 'id_category';
    protected $allowedFields = ['id_category','categoryName', 'categoryDescription', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getCategories()
    {
        return $this->findAll();
    }

    public function saveCategory($data)
    {

        return $this->insert($data);
    }

    // esta consulta es para obtener el numero de documentos que tiene cada categoria
    public function getCategoryWithNumDocuments()
    {
        $sql = "SELECT c.id_category, c.categoryName, c.categoryDescription, c.created_at, c.updated_at, COUNT(d.id_document) as num_documents
        FROM documentation_categories c LEFT JOIN documentation d ON c.id_category = d.id_category
        GROUP BY c.id_category";
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }

}
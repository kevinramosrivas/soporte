<?php

namespace App\Models;
use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table = 'documentation_categories';
    protected $primaryKey = 'id_category';
    protected $allowedFields = ['categoryName', 'categoryDescription', 'registrar_id', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getCategories()
    {
        return $this->findAll();
    }

}
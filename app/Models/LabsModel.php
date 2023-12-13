<?php

namespace App\Models;
use CodeIgniter\Model;

class LabsModel extends Model
{
    protected $table = 'laboratories';
    protected $primaryKey = 'id_lab';
    protected $allowedFields = ['num_laboratorio', 'capacity_max', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


}
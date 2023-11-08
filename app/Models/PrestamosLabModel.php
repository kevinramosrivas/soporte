<?php

namespace App\Models;
use CodeIgniter\Model;

class PrestamosLabModel extends Model
{
    protected $table = 'prestamos_lab';
    protected $primaryKey = 'id_prestamo';
    protected $allowedFields = ['num_lab', 'num_doc', 'type_doc', 'hour_entry', 'hour_exit', 'interval_num', 'registrar_id'];
    protected $useTimestamps = true;
    protected $createdField = 'hour_entry';
    protected $updatedField = 'hour_exit';
    
    public function getLab($num_lab)
    {
        $lab = $this->where('num_lab', $num_lab)->first();
        if($lab != null){
            return $lab;
        }
        return null;
    }

    public function getLabByUser($id_user)
    {
        $lab = $this->query("SELECT * FROM prestamos_lab WHERE registrar_id = $id_user")->getResultArray();
        if($lab != null){
            return $lab;
        }
        return null;
    }

    public function getAllRegisterEntryLab()
    {
        // hacer un join con la tabla de usuarios para obtener el nombre del usuario que registro la entrada
        $registerEntryLab = $this->query("SELECT * FROM prestamos_lab INNER JOIN user ON prestamos_lab.registrar_id = user.id_user")->getResultArray();

        if($registerEntryLab != null){
            return $registerEntryLab;
        }
        return null;
    }

}
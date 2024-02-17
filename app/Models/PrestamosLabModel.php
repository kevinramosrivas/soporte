<?php

namespace App\Models;
use CodeIgniter\Model;
//importar el entity 
use App\Entities\PrestamosLab;

class PrestamosLabModel extends Model
{
    protected $table = 'prestamos_lab';
    protected $primaryKey = 'id_prestamo';
    protected $allowedFields = ['id_prestamo','num_lab', 'num_doc', 'type_doc', 'hour_entry', 'hour_exit', 'interval_num', 'registrar_id'];
    protected $useTimestamps = true;
    protected $createdField = 'hour_entry';
    protected $updatedField = 'hour_exit';

    public function insertNewEntry($prestamo)
    {
        //insertar el registro
        $this->insert($prestamo);
    }
    
    
    public function getLab($num_lab)
    {
        $lab = $this->where('num_lab', $num_lab)->first();
        if($lab != null){
            return $lab;
        }
        return null;
    }


    public function getAllRegisterEntryLab()
    {
        // hacer un join con la tabla de usuarios para obtener el nombre del usuario que registro la entrada, solo obtener los registros de la semana actual
        $registerEntryLab = $this->query("SELECT * FROM prestamos_lab INNER JOIN user ON prestamos_lab.registrar_id = user.id_user WHERE WEEKOFYEAR(hour_entry) = WEEKOFYEAR(NOW())")->getResultArray();

        if($registerEntryLab != null){
            return $registerEntryLab;
        }
        return null;
    }
    public function getByTypeDocLab($type_doc, $num_lab)
    {
        if($type_doc == 0 && $num_lab == 0){
            return $this->getAllRegisterEntryLab();
        }
        if($type_doc == 0){
            $registerEntryLab = $this->query("SELECT * FROM prestamos_lab INNER JOIN user ON prestamos_lab.registrar_id = user.id_user WHERE num_lab = $num_lab")->getResultArray();
            if($registerEntryLab != null){
                return $registerEntryLab;
            }
            return null;
        }
        if($num_lab == 0){
            $registerEntryLab = $this->query("SELECT * FROM prestamos_lab INNER JOIN user ON prestamos_lab.registrar_id = user.id_user WHERE type_doc = $type_doc")->getResultArray();
            if($registerEntryLab != null){
                return $registerEntryLab;
            }
            return null;
        }
        $registerEntryLab = $this->query("SELECT * FROM prestamos_lab INNER JOIN user ON prestamos_lab.registrar_id = user.id_user WHERE type_doc = $type_doc AND num_lab = $num_lab")->getResultArray();   
        if($registerEntryLab != null){
            return $registerEntryLab;
        }
    }
    public function getByDatetime($hour_entry, $hour_exit)
    {
        //convertir a formato de hora y fecha       
        $hour_entry = date('Y-m-d', strtotime($hour_entry));
        $hour_exit = date('Y-m-d', strtotime($hour_exit));
        
        if($hour_entry == null && $hour_exit == null){
            return $this->getAllRegisterEntryLab();
        }
        $registerEntryLab = $this->query("SELECT * FROM prestamos_lab INNER JOIN user ON prestamos_lab.registrar_id = user.id_user WHERE hour_entry BETWEEN '$hour_entry' AND '$hour_exit'")->getResultArray();
        if($registerEntryLab != null){
            return $registerEntryLab;
        }
        return null;
    }

    public function getStudentsUsingLab()
    {
        //mientrs la hora de entrada y salida sea diferentes entre si, el estudiante ya salio del laboratorio
        $registerEntryLab = $this->query("SELECT * FROM prestamos_lab INNER JOIN user ON prestamos_lab.registrar_id = user.id_user WHERE hour_entry = hour_exit")->getResultArray();
        if($registerEntryLab != null){
            return $registerEntryLab;
        }
        return [];
    }

}
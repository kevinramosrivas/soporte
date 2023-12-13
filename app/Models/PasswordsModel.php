<?php

namespace App\Models;
use CodeIgniter\Model;

class PasswordsModel extends Model
{
    protected $table = 'passwords';
    protected $primaryKey = 'id_password';
    protected $allowedFields = ['typeAccount', 'accountName', 'username', 'password', 'registrar_id', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

}
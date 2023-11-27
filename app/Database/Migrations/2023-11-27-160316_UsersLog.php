<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersLog extends Migration
{
    public function up()
    {
        //crea la tabla de log de las acciones de los usuarios
        $this->forge->addField([
            'id_log' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_log', true);
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users_log');
    }

    public function down()
    {
        $this->forge->dropTable('users_log');
    }
}

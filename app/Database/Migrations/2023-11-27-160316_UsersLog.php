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
                'type' => 'VARCHAR',
                'constraint' => '36',
                'null' => false,
            ],
            'id_user' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 10,
                'null' => false,
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

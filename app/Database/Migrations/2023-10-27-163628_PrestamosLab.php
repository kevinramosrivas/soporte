<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PrestamosLab extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prestamo' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'num_lab' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'num_doc' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'type_doc' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'type_event' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 10,
                null => false,

            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id_prestamo', true);
        $this->forge->addForeignKey('id_user', 'user', 'id_user');
        $this->forge->createTable('prestamos_lab');
    }

    public function down()
    {
        $this->forge->dropTable('prestamos_lab');
    }
}

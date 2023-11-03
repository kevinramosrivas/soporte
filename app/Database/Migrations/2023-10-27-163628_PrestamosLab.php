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
                'constraint' => 10,
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
            'hour_entry' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'hour_exit' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'interval_num' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'registrar_id' => [
                'type' => 'INT',
                'constraint' => 10,
                null => false,

            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_prestamo', true);
        $this->forge->addForeignKey('registrar_id', 'user', 'id_user');
        $this->forge->createTable('prestamos_lab');
    }

    public function down()
    {
        $this->forge->dropTable('prestamos_lab');
    }
}

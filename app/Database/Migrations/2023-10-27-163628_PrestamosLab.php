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
                'constraint' => 10,
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
                'null' => false,
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
        ]);
        $this->forge->addKey('id_prestamo', true);
        $this->forge->addForeignKey('registrar_id', 'user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('num_lab', 'laboratories', 'id_lab', 'CASCADE', 'CASCADE');
        $this->forge->createTable('prestamos_lab');
    }

    public function down()
    {
        $this->forge->dropTable('prestamos_lab');
    }
}

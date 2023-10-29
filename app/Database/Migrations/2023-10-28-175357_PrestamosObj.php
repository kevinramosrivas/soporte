<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PrestamosObj extends Migration
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
            'id_thing' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'loaned_to' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'registrar_id' => [
                'type' => 'INT',
                'constraint' => 10,
                null => false,
            ],
            'returned_by' => [
                'type' => 'INT',
                'constraint' => 10,
                null => true,
            ],
            'returned_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);
        $this->forge->addKey('id_prestamo', true);
        $this->forge->addForeignKey('registrar_id', 'user', 'id_user');
        $this->forge->addForeignKey('returned_by', 'user', 'id_user');
        $this->forge->addForeignKey('id_thing', 'thing', 'id_thing');
        $this->forge->createTable('prestamos_obj');
    }

    public function down()
    {
        $this->forge->dropTable('prestamos_obj');
    }
}

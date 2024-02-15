<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Documentation extends Migration
{
    public function up()
    {
        //crear la tabla
        $this->forge->addField([
            'id_document' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => true,
            ],
            'id_category' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => false,
            ],
            'documentName' => [
                'type' => 'VARCHAR',
                'constraint' => '300',
            ],
            'documentDescription' => [
                'type' => 'VARCHAR',
                'constraint' => '300',
            ],
            'documentPath' => [
                'type' => 'VARCHAR',
                'constraint' => '300',
            ],
            'registrar_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => false,
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

        $this->forge->addKey('id_document', true);
        $this->forge->addForeignKey('id_category', 'documentation_categories', 'id_category');
        $this->forge->addForeignKey('registrar_id', 'user', 'id_user');
        $this->forge->createTable('documentation');
    }

    public function down()
    {
        //eliminar la tabla
        $this->forge->dropTable('documentation');
    }
}
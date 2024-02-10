<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DocumentationCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_category' => [
                'type' => 'INT',
                'constraint' => 10,
                //auto_increment
                'auto_increment' => true,
            ],
            'categoryName' => [
                'type' => 'VARCHAR',
                'constraint' => '300',
            ],
            'categoryDescription' => [
                'type' => 'VARCHAR',
                'constraint' => '300',
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

        $this->forge->addKey('id_category', true);
        $this->forge->createTable('documentation_categories');

        #añadir categoria por defecto
        $data = [
            'categoryName' => 'General',
            'categoryDescription' => 'Documentación general',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('documentation_categories')->insert($data);
    }

    public function down()
    {
        //eliminar la tabla
        $this->forge->dropTable('documentation_categories');
        
    }
}

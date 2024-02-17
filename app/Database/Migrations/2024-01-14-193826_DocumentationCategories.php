<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Libraries\Uuid;

class DocumentationCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_category' => [
                'type' => 'VARCHAR',
                'constraint' => '36',
                'null' => false,
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
            'id_category' => (new Uuid())->v4(),
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

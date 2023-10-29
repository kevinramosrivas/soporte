<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Thing extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_thing' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'type_thing' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'name_thing' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addKey('id_thing', true);
        $this->forge->createTable('thing');
    }

    public function down()
    {
        $this->forge->dropTable('thing');
    }
}

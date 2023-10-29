<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InventoryObsolote extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_inventory' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'type_thing' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'isbn' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'description_fault' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'registrar_id' => [
                'type' => 'INT',
                'constraint' => 10,
                null => false,
            ],
        ]);
        $this->forge->addKey('id_inventory', true);
        $this->forge->addForeignKey('registrar_id', 'user', 'id_user');
        $this->forge->createTable('inventory_obsolote');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_obsolote');
    }
}

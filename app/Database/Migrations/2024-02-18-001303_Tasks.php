<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tasks extends Migration
{
    public function up()
    {
        //THIS A TABLE FOR A SUPPORT TICKET SYSTEM
        $this->forge->addField([
            'id_task' => [
                'type' => 'INT',
                'constraint' => 10,
                'auto_increment' => true,
                'null' => false,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['open', 'closed', 'in_progress'],
                'default' => 'open',
            ],
            'requesting_unit' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => false,
            ],
            'followup_uuid_code' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
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

        $this->forge->addKey('id_task', true);
        $this->forge->addForeignKey('created_by', 'user', 'id_user');
        $this->forge->createTable('tasks');

    }

    public function down()
    {
        $this->forge->dropTable('tasks');
    }
}

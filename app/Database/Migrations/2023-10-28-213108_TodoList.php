<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TodoList extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_todo' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'name_todo' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'assigned_to' => [
                'type' => 'INT',
                'constraint' => 10,
                null => true,
            ],
            'registrar_id' => [
                'type' => 'INT',
                'constraint' => 10,
                null => false,
            ],
        ]);
        $this->forge->addKey('id_todo', true);
        $this->forge->addForeignKey('registrar_id', 'user', 'id_user');
        $this->forge->addForeignKey('assigned_to', 'user', 'id_user');
        $this->forge->createTable('todo_list');
    }

    public function down()
    {
        $this->forge->dropTable('todo_list');
    }
}

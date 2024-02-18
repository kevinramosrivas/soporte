<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaskUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_task_user' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_task' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
        ]);
        $this->forge->addKey('id_task_user', true);
        $this->forge->addForeignKey('id_task', 'tasks', 'id_task');
        $this->forge->addForeignKey('id_user', 'user', 'id_user');
        $this->forge->createTable('task_user');
    }

    public function down()
    {
        $this->forge->dropTable('task_user');
    }
}

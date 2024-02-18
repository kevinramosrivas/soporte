<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaskComments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_comment_uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false,
            ],
            'id_task' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'comment' => [
                'type' => 'TEXT',
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
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

        $this->forge->addKey('id_comment_uuid', true);
        $this->forge->addForeignKey('id_task', 'tasks', 'id_task');
        $this->forge->createTable('task_comments');
    }

    public function down()
    {
        $this->forge->dropTable('task_comments');
    }
}

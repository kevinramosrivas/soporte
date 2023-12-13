<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Passwords extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_password' => [
                'type' => 'INT',
                'constraint' => 10,
                //auto_increment
                'auto_increment' => true,
            ],
            'typeAccount' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'accountName' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'registrar_id' => [
                'type' => 'INT',
                'constraint' => 10,
                null => false,

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

        $this->forge->addKey('id_password', true);
        $this->forge->addForeignKey('registrar_id', 'user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('passwords');
    }

    public function down()
    {
        $this->forge->dropTable('passwords');
    }
}

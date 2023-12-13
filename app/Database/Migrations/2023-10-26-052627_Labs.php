<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Labs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lab' => [
                'type' => 'INT',
                'constraint' => 10,
            ],

            'num_laboratorio' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],

            'capacity_max' => [
                'type' => 'INT',
                'constraint' => 11,
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

        $this->forge->addKey('id_lab', true);
        $this->forge->createTable('laboratories');
        // añadir fila de laboratorios en la tabla de laboratorios 12 lab con capacidad de 30
        $data = [
            [
                'id_lab' => '1',
                'num_laboratorio' => 'Lab 1',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '2',
                'num_laboratorio' => 'Lab 2',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '3',
                'num_laboratorio' => 'Lab 3',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '4',
                'num_laboratorio' => 'Lab 4',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '5',
                'num_laboratorio' => 'Lab 5',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '6',
                'num_laboratorio' => 'Lab 6',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '7',
                'num_laboratorio' => 'Lab 7',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '8',
                'num_laboratorio' => 'Lab 8',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '9',
                'num_laboratorio' => 'Lab 9',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '10',
                'num_laboratorio' => 'Lab 10',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '11',
                'num_laboratorio' => 'Lab 11',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => '12',
                'num_laboratorio' => 'Lab 12',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('laboratories')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('laboratories');
    }
}

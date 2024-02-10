<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Labs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_lab' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
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
                'id_lab' => 'LAB-1-AP',
                'num_laboratorio' => 'Lab. 1 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-2-AP',
                'num_laboratorio' => 'Lab. 2 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-3-AP',
                'num_laboratorio' => 'Lab. 3 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-4-AP',
                'num_laboratorio' => 'Lab. 4 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-5-AP',
                'num_laboratorio' => 'Lab. 5 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-6-AP',
                'num_laboratorio' => 'Lab. 6 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-7-AP',
                'num_laboratorio' => 'Lab. 7 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-8-AP',
                'num_laboratorio' => 'Lab. 8 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-9-AP',
                'num_laboratorio' => 'Lab. 9 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-10-AP',
                'num_laboratorio' => 'Lab. 10 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-11-AP',
                'num_laboratorio' => 'Lab. 11 AP',
                'capacity_max' => '30',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_lab' => 'LAB-12-AP',
                'num_laboratorio' => 'Lab. 12 AP',
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

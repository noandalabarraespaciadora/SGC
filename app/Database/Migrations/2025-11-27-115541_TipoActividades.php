<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TipoActividades extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'actividad' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => '7',
                'null' => false,
                'default' => '#007bff',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tipo_actividades');
    }

    public function down()
    {
        $this->forge->dropTable('tipo_actividades');
    }
}

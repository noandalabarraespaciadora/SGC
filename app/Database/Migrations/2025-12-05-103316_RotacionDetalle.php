<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RotacionDetalle extends Migration
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
            'rotacion_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'personal_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['rotacion_id', 'personal_id']);
        $this->forge->addForeignKey('rotacion_id', 'rotaciones', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('personal_id', 'rotacion_personal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rotacion_detalles');
    }

    public function down()
    {
        $this->forge->dropTable('rotacion_detalles');
    }
}

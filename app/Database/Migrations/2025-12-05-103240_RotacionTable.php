<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RotacionTable extends Migration
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
            'fecha' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'tipo_dia_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'numero_acuerdo' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'observaciones' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
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

        $this->forge->addKey('id', true);
        $this->forge->addKey('fecha');
        $this->forge->addKey('tipo_dia_id');
        $this->forge->addForeignKey('tipo_dia_id', 'rotacion_tipos_dia', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('rotaciones');
    }

    public function down()
    {
        $this->forge->dropTable('rotaciones');
    }
}

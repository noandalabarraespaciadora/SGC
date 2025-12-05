<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RotacionTiposDias extends Migration
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
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'default' => '#007bff',
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'requiere_acuerdo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Si requiere número de acuerdo (ej: Día de Acuerdo)',
            ],
            'activo' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'orden' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 0,
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
        $this->forge->addKey(['activo', 'orden']);
        $this->forge->createTable('rotacion_tipos_dia');

        // Insertar tipos de día por defecto
        $this->db->table('rotacion_tipos_dia')->insertBatch([
            [
                'nombre' => 'Día Normal',
                'color' => '#6c757d',
                'descripcion' => 'Día regular de trabajo',
                'requiere_acuerdo' => 0,
                'orden' => 1,
            ],
            [
                'nombre' => 'Día de Acuerdo',
                'color' => '#28a745',
                'descripcion' => 'Día con acuerdo del Consejo',
                'requiere_acuerdo' => 1,
                'orden' => 2,
            ],
            [
                'nombre' => 'Concurso',
                'color' => '#ffc107',
                'descripcion' => 'Día de concursos públicos',
                'requiere_acuerdo' => 0,
                'orden' => 3,
            ],
            [
                'nombre' => 'Juramento',
                'color' => '#17a2b8',
                'descripcion' => 'Día de juramentos',
                'requiere_acuerdo' => 0,
                'orden' => 4,
            ],
            [
                'nombre' => 'Jury de Magistrados',
                'color' => '#dc3545',
                'descripcion' => 'Día de jurado de enjuiciamiento',
                'requiere_acuerdo' => 0,
                'orden' => 5,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('rotacion_tipos_dia');
    }
}

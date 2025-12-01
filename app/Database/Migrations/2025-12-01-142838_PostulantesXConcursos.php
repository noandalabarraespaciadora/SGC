<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PostulantesXConcursos extends Migration
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
            'id_concurso' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'id_nivel' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'reservaExamen' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'reservaEstudiosMedicos' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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

        // Foreign keys
        $this->forge->addForeignKey('id_concurso', 'concursos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_nivel', 'niveles_excelencia', 'id', 'CASCADE', 'SET NULL');

        // Nota: id_postulante se agregará cuando se cree la tabla Postulantes
        $this->forge->addField([
            'id_postulante' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        $this->forge->createTable('postulantes_x_concursos');
    }

    public function down()
    {
        $this->forge->dropTable('postulantes_x_concursos');
    }
}

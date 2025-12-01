<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DocentesXConcursos extends Migration
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
            'id_docente' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'id_representacion' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'condicion' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addForeignKey('id_docente', 'docentes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_representacion', 'representaciones', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('docentes_x_concursos');
    }

    public function down()
    {
        $this->forge->dropTable('docentes_x_concursos');
    }
}

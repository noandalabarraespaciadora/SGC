<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Concursos extends Migration
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
            'numero_expediente' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'caratula' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'resolucionSTJ' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'comunicacionCM' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'fecha_edicto_publicacion' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'fecha_escrito' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'fecha_oral' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'propuestas_nro_oficio' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'propuestas_fecha' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'resultadoVotacion' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'observaciones' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'id_unificado' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'id_estado_concurso' => [
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('numero_expediente');

        // Foreign keys
        $this->forge->addForeignKey('id_unificado', 'unificado', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('id_estado_concurso', 'estado_concursos', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('concursos');
    }

    public function down()
    {
        $this->forge->dropTable('concursos');
    }
}

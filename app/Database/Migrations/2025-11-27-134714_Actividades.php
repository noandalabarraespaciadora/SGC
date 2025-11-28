<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Actividades extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'fecha' => [
                'type' => 'DATE',
                'null' => true
            ],
            'hora' => [
                'type' => 'TIME',
                'null' => true
            ],
            'duracion' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'Duración en minutos'
            ],
            'id_sede' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'id_modalidad' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'id_tipo_actividad' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addPrimaryKey('id');

        // Primero crear la tabla sin el índice único
        $this->forge->createTable('actividades');

        // Luego agregar el índice único solo si no existe
        try {
            $this->db->query("CREATE UNIQUE INDEX actividades_titulo_unique ON actividades(titulo)");
        } catch (\Exception $e) {
            // El índice ya existe, continuar
        }

        // Foreign keys
        try {
            $this->forge->addForeignKey('id_sede', 'sedes', 'id', 'CASCADE', 'SET NULL');
            $this->forge->addForeignKey('id_modalidad', 'modalidades', 'id', 'CASCADE', 'SET NULL');
            $this->forge->addForeignKey('id_tipo_actividad', 'tipo_actividades', 'id', 'CASCADE', 'SET NULL');
        } catch (\Exception $e) {
            // Las foreign keys ya existen, continuar
        }
    }

    public function down()
    {
        $this->forge->dropTable('actividades');
    }
}

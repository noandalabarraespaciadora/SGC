<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Postulantes extends Migration
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
            'apellido' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'dni' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ],
            'fecha_nacimiento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'domicilio' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'estado_civil' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'nacionalidad' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'url_foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'fecha_titulo' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'fecha_matriculacion' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'antiguedad_ejercicio_profesional_letrado' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'antiguedad_ejercicio_profesional_matriculacion' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'd_foto_carnet' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'd_buena_conducta' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'd_antiguedad' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'd_sanciones' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'd_sanciones_descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'd_matricula' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'd_redam' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'd_rupv' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'psicofisico' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'd_certificado_domicilio' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'd_informacion_sumaria' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'd_informacion_sumaria_descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estudios_psicofisicos_fecha' => [
                'type' => 'DATE',
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
        $this->forge->addUniqueKey('dni');
        $this->forge->createTable('postulantes');
    }

    public function down()
    {
        $this->forge->dropTable('postulantes');
    }
}

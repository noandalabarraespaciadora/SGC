<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuarios extends Migration
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
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'mensaje_estado' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
                'unique' => true,
            ],
            'alias' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'unique' => true,
            ],
            'dni' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'telefono' => [  
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'fecha_nacimiento' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'cargo_actual' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'dependencia' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'rol' => [
                'type' => 'ENUM',
                'constraint' => ['Usuario', 'Experto', 'Sistemas'],
                'default' => 'Usuario',
            ],
            'aprobado' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['Activo', 'Ausente', 'No Disponible', 'Ocupado'],
                'default' => 'Activo',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
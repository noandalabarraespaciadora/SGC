<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RotacionPersonal extends Migration
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
            'apellido' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'categoria' => [
                'type' => 'ENUM',
                'constraint' => ['jerarquico', 'no_jerarquico'],
                'default' => 'no_jerarquico',
            ],
            'area' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'url_foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
                'comment' => 'Para ordenar la lista',
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
        $this->forge->createTable('rotacion_personal');
    }

    public function down()
    {
        $this->forge->dropTable('rotacion_personal');
    }
}

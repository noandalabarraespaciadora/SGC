<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Docentes extends Migration
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
            'apellido_y_nombre' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'url_foto' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
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
        $this->forge->addUniqueKey('apellido_y_nombre');
        $this->forge->createTable('docentes');
    }

    public function down()
    {
        $this->forge->dropTable('docentes');
    }
}

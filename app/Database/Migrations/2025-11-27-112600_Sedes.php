<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sedes extends Migration
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
            'denominacion' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'telefono' => [
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('denominacion');
        $this->forge->createTable('sedes');
    }

    public function down()
    {
        $this->forge->dropTable('sedes');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DocenteTelefonos extends Migration
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
            'id_persona' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
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
        $this->forge->addForeignKey('id_persona', 'docentes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('docente_telefonos');
    }

    public function down()
    {
        $this->forge->dropTable('docente_telefonos');
    }
}

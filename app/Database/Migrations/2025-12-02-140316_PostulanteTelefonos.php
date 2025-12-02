<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PostulanteTelefonos extends Migration
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
            'postulante_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addForeignKey('postulante_id', 'postulantes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('postulante_telefonos');
    }

    public function down()
    {
        $this->forge->dropTable('postulante_telefonos');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PostulanteEmails extends Migration
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
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->createTable('postulante_emails');
    }

    public function down()
    {
        $this->forge->dropTable('postulante_emails');
    }
}

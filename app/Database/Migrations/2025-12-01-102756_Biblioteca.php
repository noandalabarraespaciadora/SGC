<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Biblioteca extends Migration
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
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'autor' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'editorial' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'n_isbn' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'n_inventario' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'url_foto' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'ubicacion' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'descripcion' => [
                'type' => 'TEXT',
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
        $this->forge->addUniqueKey('titulo');
        $this->forge->addUniqueKey('n_inventario');
        $this->forge->createTable('biblioteca');
    }

    public function down()
    {
        $this->forge->dropTable('biblioteca');
    }
}

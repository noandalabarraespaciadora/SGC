<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNivelesExcelencia extends Migration
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
            'nivel' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'abreviatura' => [
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nivel');
        $this->forge->addUniqueKey('abreviatura');
        $this->forge->createTable('niveles_excelencia');
    }

    public function down()
    {
        $this->forge->dropTable('niveles_excelencia');
    }
}
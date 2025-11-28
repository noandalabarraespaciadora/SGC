<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveUniqueTituloFromActividades extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE actividades DROP INDEX actividades_titulo_unique');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE actividades ADD UNIQUE KEY actividades_titulo_unique (titulo)');
    }
}

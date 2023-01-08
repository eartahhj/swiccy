<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class CreateTableImages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'filename' => ['type' => 'VARCHAR', 'constraint' => 255],
            'alternate_text' => ['type' => 'VARCHAR', 'constraint' => 255],
            'width' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'height' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'mimetype' => ['type' => 'VARCHAR', 'constraint' => 255],
            'post_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('post_id', 'posts', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('images');
    }

    public function down()
    {
        $this->forge->dropTable('images', false, true);
    }
}

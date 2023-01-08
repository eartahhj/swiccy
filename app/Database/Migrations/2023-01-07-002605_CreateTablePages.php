<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class CreateTablePages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'title_it' => ['type' => 'VARCHAR', 'constraint' => 255],
            'title_en' => ['type' => 'VARCHAR', 'constraint' => 255],
            'html_it' => ['type' => 'TEXT'],
            'html_en' => ['type' => 'TEXT'],
            'url_it' => ['type' => 'VARCHAR', 'constraint' => 255],
            'url_en' => ['type' => 'VARCHAR', 'constraint' => 255],
            'user_creator_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'published' => ['type' => 'BOOLEAN', 'default' => false],
            'created_at' => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_creator_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('pages');
    }

    public function down()
    {
        $this->forge->dropTable('pages', false, true);
    }
}

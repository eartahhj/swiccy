<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class CreateTablePosts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'text' => ['type' => 'MEDIUMTEXT'],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'quantity_give' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'quantity_receive' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'phone_number' => ['type' => 'VARCHAR', 'constraint' => 255],
            'email' => ['type' => 'VARCHAR', 'constraint' => 255],
            'city' => ['type' => 'VARCHAR', 'constraint' => 255],
            'address' => ['type' => 'VARCHAR', 'constraint' => 255],
            'approved' => ['type' => 'BOOLEAN', 'default' => false],
            'language' => ['type' => 'VARCHAR', 'constraint' => 50],
            'created_at' => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts', false, true);
    }
}

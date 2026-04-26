<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\BaseConnection;

class CreateUserClientAccessTable extends Migration
{
    private function accessTableExists(): bool
    {
        /** @var BaseConnection $db */
        $db = $this->db;

        return $db->tableExists('user_client_access');
    }

    public function up()
    {
        if ($this->accessTableExists()) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'client_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('client_id');
        $this->forge->addUniqueKey(['user_id', 'client_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('client_id', 'clients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_client_access', true);
    }

    public function down()
    {
        if ($this->accessTableExists()) {
            $this->forge->dropTable('user_client_access', true);
        }
    }
}

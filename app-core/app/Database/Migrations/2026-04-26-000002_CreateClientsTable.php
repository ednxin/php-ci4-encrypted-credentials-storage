<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\BaseConnection;

class CreateClientsTable extends Migration
{
    private function clientsTableExists(): bool
    {
        /** @var BaseConnection $db */
        $db = $this->db;

        return $db->tableExists('clients');
    }

    public function up()
    {
        if ($this->clientsTableExists()) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'client_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 191,
            ],
            'encrypted_client_data' => [
                'type' => 'MEDIUMTEXT',
            ],
            'iv' => [
                'type' => 'TEXT',
            ],
            'salt' => [
                'type' => 'TEXT',
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
        $this->forge->addKey('client_name');
        $this->forge->createTable('clients', true);
    }

    public function down()
    {
        if ($this->clientsTableExists()) {
            $this->forge->dropTable('clients', true);
        }
    }
}

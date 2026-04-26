<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserClientAccessSeeder extends Seeder
{
    public function run()
    {
        $viewer = $this->db->table('users')->where('username', 'viewer')->get()->getRowArray();
        $client = $this->db->table('clients')->where('client_name', 'Sample Client')->get()->getRowArray();

        if (! $viewer || ! $client) {
            return;
        }

        $exists = $this->db->table('user_client_access')
            ->where('user_id', $viewer['id'])
            ->where('client_id', $client['id'])
            ->countAllResults();

        if ($exists > 0) {
            return;
        }

        $this->db->table('user_client_access')->insert([
            'user_id'   => $viewer['id'],
            'client_id' => $client['id'],
        ]);
    }
}

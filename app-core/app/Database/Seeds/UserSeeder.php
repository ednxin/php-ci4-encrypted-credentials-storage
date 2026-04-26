<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username'      => 'superadmin',
                'password_hash' => password_hash('SuperAdmin@123', PASSWORD_DEFAULT),
                'role'          => 'super_admin',
                'is_active'     => 1,
            ],
            [
                'username'      => 'viewer',
                'password_hash' => password_hash('Viewer@123', PASSWORD_DEFAULT),
                'role'          => 'viewer_user',
                'is_active'     => 1,
            ],
        ];

        foreach ($users as $user) {
            $exists = $this->db->table('users')->where('username', $user['username'])->countAllResults();
            if ($exists > 0) {
                continue;
            }

            $this->db->table('users')->insert($user);
        }
    }
}

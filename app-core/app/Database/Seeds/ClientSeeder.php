<?php

namespace App\Database\Seeds;

use App\Services\EncryptionService;
use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $clientName = 'Sample Client';
        $exists     = $this->db->table('clients')->where('client_name', $clientName)->countAllResults();

        if ($exists > 0) {
            return;
        }

        $service   = new EncryptionService();
        $masterKey = getenv('SEED_MASTER_KEY') ?: bin2hex(random_bytes(16));
        $payload   = $service->encrypt('Sample encrypted placeholder data.', $masterKey);

        $this->db->table('clients')->insert([
            'client_name'           => $clientName,
            'encrypted_client_data' => $payload['ciphertext'],
            'iv'                    => $payload['iv'],
            'salt'                  => $payload['salt'],
        ]);
    }
}

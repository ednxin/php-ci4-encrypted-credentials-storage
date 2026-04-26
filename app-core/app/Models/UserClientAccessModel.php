<?php

namespace App\Models;

use CodeIgniter\Model;

class UserClientAccessModel extends Model
{
    protected $table            = 'user_client_access';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'client_id',
    ];

    public function userCanAccessClient(int $userId, int $clientId): bool
    {
        return $this->where('user_id', $userId)
            ->where('client_id', $clientId)
            ->countAllResults() > 0;
    }

    public function syncUserClientAccess(int $userId, array $clientIds): void
    {
        $clientIds = array_values(array_unique(array_map(static fn ($id) => (int) $id, $clientIds)));

        $this->where('user_id', $userId)->delete();

        foreach ($clientIds as $clientId) {
            if ($clientId <= 0) {
                continue;
            }

            $this->insert([
                'user_id'   => $userId,
                'client_id' => $clientId,
            ]);
        }
    }
}

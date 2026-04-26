<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'password_hash',
        'role',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';

    public function findByUsername(string $username): ?array
    {
        $user = $this->where('username', $username)->first();

        return $user ?: null;
    }
}

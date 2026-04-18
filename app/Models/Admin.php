<?php

namespace App\Models;

use App\Core\Model;

class Admin extends Model
{
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE username = :username AND is_active = 1 LIMIT 1');
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();
        return $admin ?: null;
    }

    public function updateLastLogin(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE admins SET last_login_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}

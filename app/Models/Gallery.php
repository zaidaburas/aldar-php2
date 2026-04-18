<?php

namespace App\Models;

use App\Core\Model;

class Gallery extends Model
{
    public function countActive(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM gallery WHERE is_active = 1')->fetchColumn();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM gallery ORDER BY sort_order ASC, id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM gallery WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO gallery (title, image_path, sort_order, is_active) VALUES (:title, :image_path, :sort_order, :is_active)');
        $stmt->execute([
            'title' => $data['title'],
            'image_path' => $data['image_path'],
            'sort_order' => (int) $data['sort_order'],
            'is_active' => (int) $data['is_active'],
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE gallery SET title = :title, image_path = :image_path, sort_order = :sort_order, is_active = :is_active WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'image_path' => $data['image_path'],
            'sort_order' => (int) $data['sort_order'],
            'is_active' => (int) $data['is_active'],
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM gallery WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}

<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    }

    public function all(): array
    {
        return $this->db->query('SELECT c.*, (SELECT COUNT(*) FROM items i WHERE i.category_id = c.id) AS items_count FROM categories c ORDER BY c.sort_order ASC, c.id DESC')->fetchAll();
    }

    public function options(): array
    {
        return $this->db->query('SELECT id, name, icon FROM categories WHERE is_active = 1 ORDER BY sort_order ASC, name ASC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM categories WHERE slug = :slug';
        $params = ['slug' => $slug];
        if ($ignoreId) {
            $sql .= ' AND id != :id';
            $params['id'] = $ignoreId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO categories (name, slug, icon, description, sort_order, is_active) VALUES (:name, :slug, :icon, :description, :sort_order, :is_active)');
        $stmt->execute([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'icon' => $data['icon'] ?: null,
            'description' => $data['description'] ?: null,
            'sort_order' => (int) $data['sort_order'],
            'is_active' => (int) $data['is_active'],
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE categories SET name = :name, slug = :slug, icon = :icon, description = :description, sort_order = :sort_order, is_active = :is_active WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'icon' => $data['icon'] ?: null,
            'description' => $data['description'] ?: null,
            'sort_order' => (int) $data['sort_order'],
            'is_active' => (int) $data['is_active'],
        ]);
    }

    public function hasItems(int $id): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM items WHERE category_id = :id');
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}

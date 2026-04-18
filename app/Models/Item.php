<?php

namespace App\Models;

use App\Core\Model;

class Item extends Model
{
    public function count(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM items')->fetchColumn();
    }

    public function popularCount(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM items WHERE is_popular = 1')->fetchColumn();
    }

    public function activeCount(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM items WHERE is_active = 1')->fetchColumn();
    }

    public function all(array $filters = []): array
    {
        $sql = 'SELECT i.*, c.name AS category_name, c.icon AS category_icon FROM items i INNER JOIN categories c ON c.id = i.category_id WHERE 1 = 1';
        $params = [];

        if (!empty($filters['category_id'])) {
            $sql .= ' AND i.category_id = :category_id';
            $params['category_id'] = (int) $filters['category_id'];
        }

        if (!empty($filters['search'])) {
            $sql .= ' AND (i.name LIKE :search OR i.short_description LIKE :search OR c.name LIKE :search)';
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $sql .= ' ORDER BY i.sort_order ASC, i.id DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM items WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM items WHERE slug = :slug';
        $params = ['slug' => $slug];
        if ($ignoreId) {
            $sql .= ' AND id != :id';
            $params['id'] = $ignoreId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function popularCountExcluding(?int $ignoreId = null): int
    {
        $sql = 'SELECT COUNT(*) FROM items WHERE is_popular = 1';
        $params = [];
        if ($ignoreId) {
            $sql .= ' AND id != :id';
            $params['id'] = $ignoreId;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO items (category_id, name, slug, short_description, description, price, image_path, icon, is_popular, is_active, sort_order) VALUES (:category_id, :name, :slug, :short_description, :description, :price, :image_path, :icon, :is_popular, :is_active, :sort_order)');
        $stmt->execute([
            'category_id' => (int) $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'short_description' => $data['short_description'] ?: null,
            'description' => $data['description'] ?: null,
            'price' => $data['price'],
            'image_path' => $data['image_path'] ?: null,
            'icon' => $data['icon'] ?: null,
            'is_popular' => (int) $data['is_popular'],
            'is_active' => (int) $data['is_active'],
            'sort_order' => (int) $data['sort_order'],
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE items SET category_id = :category_id, name = :name, slug = :slug, short_description = :short_description, description = :description, price = :price, image_path = :image_path, icon = :icon, is_popular = :is_popular, is_active = :is_active, sort_order = :sort_order WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'category_id' => (int) $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'short_description' => $data['short_description'] ?: null,
            'description' => $data['description'] ?: null,
            'price' => $data['price'],
            'image_path' => $data['image_path'] ?: null,
            'icon' => $data['icon'] ?: null,
            'is_popular' => (int) $data['is_popular'],
            'is_active' => (int) $data['is_active'],
            'sort_order' => (int) $data['sort_order'],
        ]);
    }



    public function optionsForFeatured(): array
    {
        return $this->db->query('SELECT i.id, i.name, i.short_description, c.name AS category_name, c.icon AS category_icon FROM items i INNER JOIN categories c ON c.id = i.category_id WHERE i.is_active = 1 ORDER BY i.name ASC')->fetchAll();
    }

    public function isSelectableFeatured(int $id): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM items WHERE id = :id AND is_active = 1');
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM items WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}

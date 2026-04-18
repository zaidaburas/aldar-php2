<?php

namespace App\Models;

use App\Core\Model;

class SliderAd extends Model
{
    public function countActive(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM slider_ads WHERE is_active = 1')->fetchColumn();
    }

    public function all(): array
    {
        return $this->db->query('SELECT * FROM slider_ads ORDER BY sort_order ASC, id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM slider_ads WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO slider_ads (title, subtitle, image_path, button_text, link_url, sort_order, is_active) VALUES (:title, :subtitle, :image_path, :button_text, :link_url, :sort_order, :is_active)');
        $stmt->execute([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?: null,
            'image_path' => $data['image_path'],
            'button_text' => $data['button_text'] ?: null,
            'link_url' => $data['link_url'] ?: null,
            'sort_order' => (int) $data['sort_order'],
            'is_active' => (int) $data['is_active'],
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE slider_ads SET title = :title, subtitle = :subtitle, image_path = :image_path, button_text = :button_text, link_url = :link_url, sort_order = :sort_order, is_active = :is_active WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?: null,
            'image_path' => $data['image_path'],
            'button_text' => $data['button_text'] ?: null,
            'link_url' => $data['link_url'] ?: null,
            'sort_order' => (int) $data['sort_order'],
            'is_active' => (int) $data['is_active'],
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM slider_ads WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}

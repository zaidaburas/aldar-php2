<?php

namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    public function allKeyValue(): array
    {
        $stmt = $this->db->query('SELECT setting_key, setting_value FROM settings');
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['setting_key']] = $row['setting_value'];
        }
        return $result;
    }

    public function definitions(): array
    {
        return [
            'general' => [
                'site_title' => ['label' => 'اسم الموقع', 'type' => 'text'],
                'site_description' => ['label' => 'وصف الموقع', 'type' => 'text'],
            ],
            'links' => [
                'order_now_url' => ['label' => 'رابط اطلب الآن', 'type' => 'text'],
                'whatsapp_url' => ['label' => 'رابط الواتساب', 'type' => 'text'],
                'contact_url' => ['label' => 'رابط اتصل بنا', 'type' => 'text'],
            ],
            'hero' => [
                'topbar_text' => ['label' => 'نص الشريط العلوي', 'type' => 'text'],
                'hero_title' => ['label' => 'عنوان الهيرو', 'type' => 'text'],
                'hero_description' => ['label' => 'وصف الهيرو', 'type' => 'textarea'],
            ],
            'about' => [
                'about_text' => ['label' => 'نص من نحن', 'type' => 'textarea'],
            ],
            'featured' => [
                'featured_item_id' => ['label' => 'الوجبة المميزة', 'type' => 'select'],
            ],
        ];
    }

    public function upsertMany(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO settings (setting_key, setting_value, setting_type, setting_group) VALUES (:setting_key, :setting_value, :setting_type, :setting_group) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), setting_type = VALUES(setting_type), setting_group = VALUES(setting_group)');

        foreach ($this->definitions() as $group => $fields) {
            foreach ($fields as $key => $meta) {
                $stmt->execute([
                    'setting_key' => $key,
                    'setting_value' => $data[$key] ?? null,
                    'setting_type' => $meta['type'],
                    'setting_group' => $group,
                ]);
            }
        }
    }

    public function setValue(string $key, mixed $value, string $type = 'text', string $group = 'general'): void
    {
        $stmt = $this->db->prepare('INSERT INTO settings (setting_key, setting_value, setting_type, setting_group) VALUES (:setting_key, :setting_value, :setting_type, :setting_group) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), setting_type = VALUES(setting_type), setting_group = VALUES(setting_group)');
        $stmt->execute([
            'setting_key' => $key,
            'setting_value' => $value,
            'setting_type' => $type,
            'setting_group' => $group,
        ]);
    }
}

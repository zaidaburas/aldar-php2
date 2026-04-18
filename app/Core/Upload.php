<?php

namespace App\Core;

class Upload
{
    public static function image(string $field, string $folder): ?string
    {
        if (!isset($_FILES[$field]) || !is_array($_FILES[$field])) {
            return null;
        }

        $file = $_FILES[$field];

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (($file['error'] ?? 0) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('فشل رفع الصورة.');
        }

        if (($file['size'] ?? 0) > (int) config('uploads.max_size')) {
            throw new \RuntimeException('حجم الصورة أكبر من الحد المسموح.');
        }

        $extension = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));
        $allowed = config('uploads.allowed_extensions', []);
        if (!in_array($extension, $allowed, true)) {
            throw new \RuntimeException('امتداد الصورة غير مسموح.');
        }

        $mime = mime_content_type($file['tmp_name']);
        if (!str_starts_with((string) $mime, 'image/')) {
            throw new \RuntimeException('الملف المرفوع ليس صورة صالحة.');
        }

        $targetDir = rtrim(config('uploads.base_path'), '/') . '/' . trim($folder, '/');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $fileName = uniqid($folder . '_', true) . '.' . $extension;
        $targetPath = $targetDir . '/' . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new \RuntimeException('تعذر حفظ الصورة على الخادم.');
        }

        return trim($folder, '/') . '/' . $fileName;
    }

    public static function remove(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $fullPath = rtrim(config('uploads.base_path'), '/') . '/' . ltrim($relativePath, '/');
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}

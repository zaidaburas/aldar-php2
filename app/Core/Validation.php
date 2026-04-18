<?php

namespace App\Core;

class Validation
{
    public static function required(array $data, array $fields): array
    {
        $errors = [];

        foreach ($fields as $field => $label) {
            if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                $errors[$field] = "حقل {$label} مطلوب.";
            }
        }

        return $errors;
    }
}

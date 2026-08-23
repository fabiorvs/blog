<?php

namespace App\Services;

final class SlugService
{
    public static function make(string $value, string $fallback = 'conteudo'): string
    {
        $value = trim($value);
        $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        if ($transliterated !== false) {
            $value = $transliterated;
        }

        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        $value = trim($value, '-');

        return $value !== '' ? $value : $fallback;
    }
}

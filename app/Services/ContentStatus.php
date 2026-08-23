<?php

namespace App\Services;

final class ContentStatus
{
    public const PUBLISHED = 'publicado';
    public const DRAFT = 'rascunho';
    public const REVIEW = 'aprovacao';

    public static function options(): array
    {
        return [
            self::PUBLISHED => 'Publicado',
            self::DRAFT => 'Rascunho',
            self::REVIEW => 'Em aprovação',
        ];
    }

    public static function normalize(?string $status): string
    {
        $status = strtolower(trim((string) $status));
        $status = str_replace(['ç', 'ã'], ['c', 'a'], $status);

        if ($status === 'em aprovacao') {
            $status = self::REVIEW;
        }

        return array_key_exists($status, self::options()) ? $status : self::DRAFT;
    }

    public static function label(?string $status): string
    {
        return self::options()[self::normalize($status)];
    }

    public static function isPubliclyListed(?string $status): bool
    {
        return self::normalize($status) === self::PUBLISHED;
    }

    public static function isReview(?string $status): bool
    {
        return self::normalize($status) === self::REVIEW;
    }
}

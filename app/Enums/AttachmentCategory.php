<?php

namespace App\Enums;

enum AttachmentCategory: string
{
    case Before = 'before';
    case After = 'after';
    case Evidence = 'evidence';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Before => 'Sebelum',
            self::After => 'Sesudah',
            self::Evidence => 'Bukti',
            self::Other => 'Lainnya',
        };
    }
}

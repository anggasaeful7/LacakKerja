<?php

namespace App\Enums;

enum AssetStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Retired = 'retired';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::Retired => 'Retired',
        };
    }
}

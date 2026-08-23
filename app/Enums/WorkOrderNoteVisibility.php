<?php

namespace App\Enums;

enum WorkOrderNoteVisibility: string
{
    case Internal = 'internal';
    case Customer = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::Internal => 'Internal',
            self::Customer => 'Pelanggan',
        };
    }
}

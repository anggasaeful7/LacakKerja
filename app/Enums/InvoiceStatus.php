<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case Draft = 'draft';
    case Issued = 'issued';
    case PartiallyPaid = 'partially_paid';
    case Paid = 'paid';
    case Overdue = 'overdue';
    case Void = 'void';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Issued => 'Terbit',
            self::PartiallyPaid => 'Sebagian dibayar',
            self::Paid => 'Lunas',
            self::Overdue => 'Jatuh tempo',
            self::Void => 'Dibatalkan',
        };
    }

    public function isPayable(): bool
    {
        return in_array($this, [self::Issued, self::PartiallyPaid, self::Overdue], true);
    }

    public function isEditable(): bool
    {
        return $this === self::Draft;
    }
}

<?php

namespace App\Enums;

enum WorkOrderStatus: string
{
    case Draft = 'draft';
    case Scheduled = 'scheduled';
    case Dispatched = 'dispatched';
    case EnRoute = 'en_route';
    case InProgress = 'in_progress';
    case OnHold = 'on_hold';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Scheduled => 'Terjadwal',
            self::Dispatched => 'Dikirim',
            self::EnRoute => 'Dalam perjalanan',
            self::InProgress => 'Sedang dikerjakan',
            self::OnHold => 'Ditunda',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }

    /** @return array<int, self> */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::Draft => [self::Scheduled, self::Cancelled],
            self::Scheduled => [self::Dispatched, self::Cancelled],
            self::Dispatched => [self::EnRoute, self::InProgress, self::Cancelled],
            self::EnRoute => [self::InProgress, self::OnHold, self::Cancelled],
            self::InProgress => [self::OnHold, self::Completed, self::Cancelled],
            self::OnHold => [self::Scheduled, self::InProgress, self::Cancelled],
            self::Completed => [self::InProgress],
            self::Cancelled => [],
        };
    }

    public function requiresReason(): bool
    {
        return in_array($this, [self::OnHold, self::Cancelled, self::InProgress], true);
    }

    public function isTerminal(): bool
    {
        return in_array($this, [self::Completed, self::Cancelled], true);
    }
}

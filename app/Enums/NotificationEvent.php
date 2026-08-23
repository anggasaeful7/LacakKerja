<?php

namespace App\Enums;

enum NotificationEvent: string
{
    case Assigned = 'work_order.assigned';
    case Rescheduled = 'work_order.rescheduled';
    case Cancelled = 'work_order.cancelled';
    case Overdue = 'work_order.overdue';
    case Completed = 'work_order.completed';
    case InvoiceIssued = 'invoice.issued';
    case InvoiceDue = 'invoice.due';
    case InvoicePaid = 'invoice.paid';
    case RoleChanged = 'membership.role_changed';

    public function label(): string
    {
        return match ($this) {
            self::Assigned => 'Work order ditugaskan',
            self::Rescheduled => 'Work order dijadwalkan ulang',
            self::Cancelled => 'Work order dibatalkan',
            self::Overdue => 'Work order melewati SLA',
            self::Completed => 'Work order selesai',
            self::InvoiceIssued => 'Invoice diterbitkan',
            self::InvoiceDue => 'Invoice jatuh tempo',
            self::InvoicePaid => 'Invoice dibayar',
            self::RoleChanged => 'Peran anggota berubah',
        };
    }
}

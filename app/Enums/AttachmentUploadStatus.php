<?php

namespace App\Enums;

enum AttachmentUploadStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Completed => 'Selesai',
            self::Failed => 'Gagal',
        };
    }
}

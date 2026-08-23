<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Organization;
use Illuminate\Validation\ValidationException;

class AttachmentQuota
{
    public function ensureAvailable(Organization $organization, int $incomingBytes): void
    {
        $limit = data_get($organization->settings, 'attachment_quota_bytes');

        if (! is_numeric($limit)) {
            return;
        }

        $used = Attachment::query()
            ->whereHas('workOrder', fn ($query) => $query->where('organization_id', $organization->id))
            ->sum('size_bytes');

        if (((int) $used + $incomingBytes) > (int) $limit) {
            throw ValidationException::withMessages([
                'file' => 'Kuota file organisasi sudah penuh. Hapus bukti lama atau naikkan batas storage.',
            ]);
        }
    }
}

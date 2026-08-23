<?php

namespace App\Models;

use App\Enums\AttachmentCategory;
use App\Enums\AttachmentUploadStatus;
use Database\Factories\AttachmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string|null $client_upload_id
 * @property AttachmentUploadStatus $upload_status
 * @property AttachmentCategory $category
 */
#[Fillable(['work_order_id', 'client_upload_id', 'uploaded_by', 'category', 'disk', 'path', 'original_name', 'mime_type', 'size_bytes', 'checksum', 'upload_status', 'is_required'])]
class Attachment extends Model
{
    /** @use HasFactory<AttachmentFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'category' => AttachmentCategory::class,
            'upload_status' => AttachmentUploadStatus::class,
            'size_bytes' => 'integer',
            'is_required' => 'boolean',
        ];
    }

    /** @return BelongsTo<WorkOrder, $this> */
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    /** @return BelongsTo<User, $this> */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}

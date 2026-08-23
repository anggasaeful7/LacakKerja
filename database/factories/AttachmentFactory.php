<?php

namespace Database\Factories;

use App\Enums\AttachmentCategory;
use App\Enums\AttachmentUploadStatus;
use App\Models\Attachment;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Attachment> */
class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition(): array
    {
        return [
            'work_order_id' => WorkOrder::factory(),
            'uploaded_by' => User::factory(),
            'category' => AttachmentCategory::Evidence,
            'disk' => 'local',
            'path' => 'work-orders/'.fake()->uuid().'/evidence.jpg',
            'original_name' => 'evidence.jpg',
            'mime_type' => 'image/jpeg',
            'size_bytes' => 120000,
            'checksum' => hash('sha256', fake()->uuid()),
            'upload_status' => AttachmentUploadStatus::Completed,
            'is_required' => false,
        ];
    }

    public function required(): static
    {
        return $this->state(fn () => ['is_required' => true]);
    }
}

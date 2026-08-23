<?php

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use Database\Factories\TechnicianProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $organization_id
 * @property int $user_id
 * @property string|null $employee_code
 * @property string|null $phone
 * @property array<int, string>|null $skills
 * @property string $display_color
 * @property array<string, mixed>|null $availability
 */
#[Fillable(['organization_id', 'user_id', 'employee_code', 'phone', 'skills', 'display_color', 'availability'])]
class TechnicianProfile extends Model
{
    /** @use HasFactory<TechnicianProfileFactory> */
    use BelongsToOrganization, HasFactory;

    protected function casts(): array
    {
        return [
            'skills' => 'array',
            'availability' => 'array',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return array{start: string, end: string}|null */
    public function availabilityFor(string $day): ?array
    {
        $availability = $this->availability ?? [];
        $slot = $availability[strtolower($day)] ?? null;

        if (! is_array($slot) || ! isset($slot['start'], $slot['end'])) {
            return null;
        }

        return [
            'start' => (string) $slot['start'],
            'end' => (string) $slot['end'],
        ];
    }
}

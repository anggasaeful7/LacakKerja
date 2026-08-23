<?php

namespace App\Services;

use App\Models\ActivityLog;
use BackedEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuditLogger
{
    /**
     * @param  array<string, mixed>  $changes
     * @param  array<string, mixed>  $metadata
     */
    public function log(string $event, ?Model $subject = null, ?int $organizationId = null, array $changes = [], array $metadata = []): ActivityLog
    {
        $organizationId ??= $this->organizationId($subject);

        if ($organizationId === null) {
            throw new \InvalidArgumentException('Audit log membutuhkan organization_id.');
        }

        $request = app()->bound('request') ? app('request') : null;

        return ActivityLog::query()->create([
            'organization_id' => $organizationId,
            'actor_id' => Auth::id(),
            'event' => $event,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'changes' => $this->redact($changes),
            'metadata' => $this->redact($metadata),
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'request_id' => $request?->header('X-Request-ID'),
            'created_at' => now(),
        ]);
    }

    /**
     * @param  array<string, mixed>  $value
     * @return array<string, mixed>
     */
    public function redact(array $value): array
    {
        return $this->redactValue($value);
    }

    private function organizationId(?Model $subject): ?int
    {
        if ($subject === null) {
            return null;
        }

        $organizationId = $subject->getAttribute('organization_id');
        if ($organizationId !== null) {
            return (int) $organizationId;
        }

        if (method_exists($subject, 'workOrder')) {
            $workOrderOrganizationId = $subject->workOrder()->value('organization_id');

            return $workOrderOrganizationId === null ? null : (int) $workOrderOrganizationId;
        }

        return null;
    }

    private function redactValue(mixed $value, ?string $key = null): mixed
    {
        if ($key !== null && preg_match('/password|token|secret|authorization|cookie|file|content/i', $key) === 1) {
            return '[REDACTED]';
        }

        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if (is_array($value)) {
            $redacted = [];
            foreach ($value as $childKey => $childValue) {
                $redacted[$childKey] = $this->redactValue($childValue, is_string($childKey) ? $childKey : null);
            }

            return $redacted;
        }

        if (is_string($value) && Str::length($value) > 2000) {
            return Str::limit($value, 2000, '…');
        }

        if (is_scalar($value) || $value === null) {
            return $value;
        }

        return Str::limit((string) $value, 500, '…');
    }
}

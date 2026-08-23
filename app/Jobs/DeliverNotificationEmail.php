<?php

namespace App\Jobs;

use App\Mail\NotificationMail;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class DeliverNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    /** @var array<int, int> */
    public array $backoff = [60, 300];

    /** @param array<string, mixed> $payload */
    public function __construct(
        public readonly int $userId,
        public readonly int $organizationId,
        public readonly string $event,
        public readonly array $payload,
    ) {}

    public function handle(): void
    {
        $user = User::query()->findOrFail($this->userId);
        Mail::to($user)->send(new NotificationMail(
            (string) ($this->payload['title'] ?? $this->event),
            (string) ($this->payload['body'] ?? ''),
            $this->payload['route'] ?? null,
        ));
    }

    public function failed(?Throwable $exception): void
    {
        app(AuditLogger::class)->log(
            'notification.email_failed',
            organizationId: $this->organizationId,
            metadata: [
                'event' => $this->event,
                'recipient_id' => $this->userId,
                'exception' => $exception === null ? null : $exception::class,
            ],
        );
    }
}

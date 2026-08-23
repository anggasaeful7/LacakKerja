<?php

namespace App\Notifications;

use App\Enums\NotificationEvent;
use App\Models\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FieldServiceNotification extends Notification
{
    use Queueable;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        public readonly Organization $organization,
        public readonly NotificationEvent $event,
        public readonly array $payload,
    ) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /** @return array<string, mixed> */
    public function toDatabase(object $notifiable): array
    {
        return [
            'organization_id' => $this->organization->id,
            'event' => $this->event->value,
            'event_label' => $this->event->label(),
            'title' => (string) ($this->payload['title'] ?? $this->event->label()),
            'body' => (string) ($this->payload['body'] ?? ''),
            'route' => $this->payload['route'] ?? route('notifications.index'),
            'severity' => (string) ($this->payload['severity'] ?? 'info'),
            'subject_type' => $this->payload['subject_type'] ?? null,
            'subject_id' => $this->payload['subject_id'] ?? null,
        ];
    }

    /** @return array<string, mixed> */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}

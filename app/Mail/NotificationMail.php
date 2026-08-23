<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $title,
        public readonly string $body,
        public readonly ?string $route = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'LacakKerja · '.$this->title);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.notification');
    }
}

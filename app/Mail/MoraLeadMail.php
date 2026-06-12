<?php

namespace App\Mail;

use App\Models\MoraLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MoraLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public MoraLead $lead) {}

    public function envelope(): Envelope
    {
        $emoji = match($this->lead->score) {
            'hot'  => '🔥',
            'warm' => '⚡',
            default => '📩',
        };
        $source = $this->lead->source === 'cs_form' ? '[CS Form]' : '[MORA Chat]';
        return new Envelope(
            subject: "{$emoji} Lead {$source} — {$this->lead->name} · " . now()->format('d M Y H:i') . ' WIB',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.mora-lead',
        );
    }
}

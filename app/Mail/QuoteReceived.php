<?php

namespace App\Mail;

use App\Models\Provider;
use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Quote    $quote,
        public Provider $provider,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo pedido de orçamento — ' . $this->quote->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quote-received',
        );
    }
}

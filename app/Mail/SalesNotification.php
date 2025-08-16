<?php

namespace App\Mail;

use App\Models\Tickets;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SalesNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $event;
    public $attendee;
    public $organizer;
    public $transactionId;

    /**
     * Create a new message instance.
     */
    public function __construct(Tickets $ticket, $transactionId = null)
    {
        $this->ticket = $ticket;
        $this->event = $ticket->event;
        $this->attendee = $ticket->user;
        $this->organizer = $ticket->event->user;
        $this->transactionId = $transactionId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Ticket Sale - ' . $this->event->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sales-notification',
            with: [
                'ticket' => $this->ticket,
                'event' => $this->event,
                'attendee' => $this->attendee,
                'organizer' => $this->organizer,
                'transactionId' => $this->transactionId,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

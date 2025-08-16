<?php

namespace App\Mail;

use App\Models\Tickets;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $event;
    public $attendee;
    public $transactionId;

    /**
     * Create a new message instance.
     */
    public function __construct(Tickets $ticket, $transactionId = null)
    {
        $this->ticket = $ticket;
        $this->event = $ticket->event;
        $this->attendee = $ticket->user;
        $this->transactionId = $transactionId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Confirmation - ' . $this->event->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-confirmation',
            with: [
                'ticket' => $this->ticket,
                'event' => $this->event,
                'attendee' => $this->attendee,
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

@extends('emails.layout')

@section('title', 'Ticket Confirmation - ' . $event->title)

@section('header-title', 'Ticket Confirmed!')
@section('header-subtitle', 'Your tickets are ready')

@section('content')
    <h2>Hello {{ $attendee->name }}! 🎉</h2>
    
    <p>Great news! Your ticket purchase has been confirmed and your payment has been successfully processed. You're all set for an amazing event experience!</p>
    
    <div class="success-box">
        <h4>✅ Payment Confirmed</h4>
        <p>Your payment of <strong>${{ number_format($ticket->total_amount, 2) }}</strong> has been successfully processed.</p>
        @if($transactionId)
            <p><strong>Transaction ID:</strong> {{ $transactionId }}</p>
        @endif
    </div>
    
    <h3>📅 Event Information</h3>
    <div class="info-box">
        <h4>{{ $event->title }}</h4>
        <p>
            <strong>📍 Location:</strong> {{ $event->location }}<br>
            <strong>📅 Date:</strong> {{ $event->date_start->format('l, F j, Y') }}<br>
            <strong>🕐 Time:</strong> {{ $event->date_start->format('g:i A') }} - {{ $event->date_end->format('g:i A') }}<br>
            <strong>👤 Organizer:</strong> {{ $event->user->name }}<br>
            @if($event->category)
                <strong>🏷️ Category:</strong> {{ $event->category->name }}<br>
            @endif
        </p>
    </div>
    
    <h3>🎫 Your Ticket Details</h3>
    <div class="info-box">
        <h4>Ticket Information</h4>
        <p>
            <strong>Ticket ID:</strong> #{{ $ticket->id }}<br>
            <strong>Ticket Type:</strong> {{ ucfirst($ticket->ticket_type) }}<br>
            <strong>Quantity:</strong> {{ $ticket->quantity }} {{ Str::plural('ticket', $ticket->quantity) }}<br>
            <strong>Price per Ticket:</strong> ${{ number_format($ticket->price, 2) }}<br>
            <strong>Total Amount:</strong> ${{ number_format($ticket->total_amount, 2) }}<br>
            <strong>Purchase Date:</strong> {{ $ticket->purchased_at->format('M j, Y \a\t g:i A') }}<br>
            <strong>Payment Method:</strong> {{ ucfirst($ticket->payment_method) }}
        </p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <div class="info-box">
            <h4>📱 Your Digital Ticket</h4>
            <p>Present this ticket ID at the event entrance:</p>
            <div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin: 15px 0;">
                <div style="font-size: 24px; font-weight: bold; color: #1f2937; letter-spacing: 2px;">
                    TICKET-{{ str_pad($ticket->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-top: 5px;">
                    Ticket Reference Number
                </div>
            </div>
            <p style="font-size: 14px; color: #6b7280;">
                💡 Save this email or take a screenshot for easy access at the event
            </p>
        </div>
    </div>
    
    <h3>📋 Important Information</h3>
    <ul>
        <li><strong>Arrival:</strong> Please arrive 15-30 minutes before the event starts</li>
        <li><strong>Entry:</strong> Present your ticket ID (above) at the entrance</li>
        <li><strong>Contact:</strong> For event-specific questions, contact the organizer</li>
        <li><strong>Refunds:</strong> Check the event's refund policy for cancellation terms</li>
        <li><strong>Updates:</strong> You'll receive notifications about any event changes</li>
    </ul>
    
    <div class="warning-box">
        <h4>⚠️ Please Note</h4>
        <p>
            • Keep this confirmation email safe - you'll need it for event entry<br>
            • Tickets are non-transferable unless specified by the organizer<br>
            • Event details may be subject to change - you'll be notified of any updates
        </p>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('ticket.show', $event) }}" class="btn" style="margin-right: 10px;">
            View Event Details
        </a>
        <a href="{{ url('/my-tickets') }}" class="btn btn-secondary">
            My Tickets
        </a>
    </div>
    
    <h3>📞 Need Help?</h3>
    <p>If you have any questions about your ticket or the event:</p>
    <ul>
        <li>📧 <strong>Event Organizer:</strong> <a href="mailto:{{ $event->user->email }}">{{ $event->user->email }}</a></li>
        <li>🎫 <strong>Ticket Support:</strong> <a href="mailto:tickets@evenext.com">tickets@evenext.com</a></li>
        <li>💬 <strong>General Support:</strong> <a href="mailto:support@evenext.com">support@evenext.com</a></li>
    </ul>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/') }}" class="btn btn-secondary">Discover More Events</a>
    </div>
    
    <p>Thank you for choosing Evenext! We hope you have an amazing time at {{ $event->title }}.</p>
    
    <p>Best regards,<br>
    <strong>The Evenext Team</strong></p>
@endsection
